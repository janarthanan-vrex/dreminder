<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\FaqCategory;
use App\Models\TermsPage;
use App\Models\PlanPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class PagesController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email',
            'phone' => 'required|numeric|digits_between:10,15',
            'subject'    => 'required|string|max:200',
            'message'    => 'required|string|min:10',
        ]);

        Mail::send(
            'emails.contact',
            ['data' => $validated],
            function ($mail) use ($validated) {

                $mail->to('jana2407@yopmail.com')
                    ->subject($validated['subject']);
            }
        );

        return response()->json([
            'status' => true,
            'message' => 'Message sent successfully'
        ]);
    }

    public function termsPage()
{
    $terms = TermsPage::where('slug', 'terms-condition')->first();

    return view('terms', compact('terms'));
}

public function faqPage()
{
    $categories = FaqCategory::with(['faqs' => function($q) {
            $q->where('status', 'active')->orderBy('sort_order');
        }])
        ->where('is_visible', true)
        ->orderBy('sort_order')
        ->get();

    return view('faq', compact('categories'));
}

public function pricingPage()
{
        $plans = PlanPrice::where('status','Active')
        ->latest()
        ->get();

    return view('pricing', compact('plans'));
}

public function blogPage(Request $request)
{
    $posts = BlogPost::where('is_active', true)
                     ->latest()
                     ->get();

    $featured = $posts->first();
    $rest     = $posts->skip(1)->values();

    return view('blog', compact('posts', 'featured', 'rest'));
}

public function blogDetail($slug)
{
    $post = BlogPost::where('slug', $slug)->where('is_active', true)->firstOrFail();

    // Read time
    $wordCount = str_word_count(strip_tags($post->content));
    $readTime  = max(1, ceil($wordCount / 200));

    // Related posts — same category, exclude current
    $related = BlogPost::where('is_active', true)
                       ->where('category', $post->category)
                       ->where('id', '!=', $post->id)
                       ->latest()
                       ->take(3)
                       ->get();

    // Prev / Next
    $prev = BlogPost::where('is_active', true)->where('id', '<', $post->id)->orderBy('id', 'desc')->first();
    $next = BlogPost::where('is_active', true)->where('id', '>', $post->id)->orderBy('id', 'asc')->first();

    return view('blog-detail', compact('post', 'readTime', 'related', 'prev', 'next'));
}

}
