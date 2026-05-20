<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // 🔥 Share categories globally to layout
        View::composer('user.layouts.app', function ($view) {

            $user = Auth::user();

            $cats = Category::with([

                'subcategories' => function ($query) use ($user) {

                    $query->where('status', 'Active')

                        ->where(function ($q) use ($user) {

                            $q->where('role', 'admin')

                                ->orWhere(function ($subQ) use ($user) {

                                    $subQ->where('role', 'user')

                                        ->where('created_by', $user?->id);

                                });

                        });

                }

            ])
            ->where('status', 'Active')

            ->get()

            ->mapWithKeys(function ($category) {

                return [

                    $category->id => [

                        'id' => $category->id,

                        'name' => $category->name,

                        'icon' => $category->icon,

                        'color' => $category->color,

                        'subs' => $category->subcategories
                            ->pluck('name')
                            ->toArray()

                    ]

                ];

            })

            ->toArray();

            $view->with('cats', $cats);

        });
    }
}