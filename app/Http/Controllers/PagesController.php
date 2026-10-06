<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\FaqCategory;
<<<<<<< HEAD
use App\Models\PrivacyPolicy;
use App\Models\TermsPage;

=======
use App\Models\TermsPage;
use App\Models\PrivacyPolicy;
>>>>>>> 14b4245 (full updated code)
use App\Models\PlanPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class PagesController extends Controller
{
    public function send(Request $request)
    {
<<<<<<< HEAD
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email',
            'phone' => 'required|numeric|digits_between:10,15',
            'subject'    => 'required|string|max:200',
            'message'    => 'required|string|min:10',
        ]);
=======
        $validated = $request->validate(
            [
                'first_name' => 'required|string|max:100',
                'last_name'  => 'required|string|max:100',
                'email'      => 'required|email:rfc,dns',
                'phone'      => 'required|numeric|digits_between:10,15',
                'subject'    => 'required|string|max:200',
                'message'    => 'required|string|min:10',
            ],
            [
                'first_name.required' => 'First name is required.',
                'first_name.max'      => 'First name must not exceed 100 characters.',

                'last_name.required'  => 'Last name is required.',
                'last_name.max'       => 'Last name must not exceed 100 characters.',

                'email.required'      => 'Email address is required.',
                'email.email'         => 'Please enter a valid email address.',

                'phone.required'      => 'Phone number is required.',
                'phone.numeric'       => 'Phone number must contain only digits.',
                'phone.digits_between' => 'Phone number must be between 10 and 15 digits.',

                'subject.required'    => 'Subject is required.',
                'subject.max'         => 'Subject must not exceed 200 characters.',

                'message.required'    => 'Message is required.',
                'message.min'         => 'Message must contain at least 10 characters.',
            ]
        );
>>>>>>> 14b4245 (full updated code)

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
<<<<<<< HEAD
    {
        $terms = TermsPage::where('slug', 'Privacy Policy')->first();
        return view('terms', compact('terms'));
    }

     public function privacyPage()
    {
        $privacy = PrivacyPolicy::where('slug', 'Privacy-Policy')->first();
=======
{
    
    $terms = TermsPage::where('slug', 'terms-condition')->first();

    return view('terms', compact('terms'));
}

 public function privacyPage()
    {
        $privacy = PrivacyPolicy::where('slug', 'Privacy-Policy')->first();
        

>>>>>>> 14b4245 (full updated code)
        return view('privacy', compact('privacy'));
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

<<<<<<< HEAD
public function blogPage(Request $request)
{
    $posts = BlogPost::where('is_active', true)
                     ->latest()
                     ->get();

    $featured = $posts->first();
    $rest     = $posts->skip(1)->values();

    return view('blog', compact('posts', 'featured', 'rest'));
=======
 public function blogPage(Request $request)
{
    $posts = BlogPost::where('is_active', true)
        ->latest()
        ->get();

    return view('blog', compact('posts'));
>>>>>>> 14b4245 (full updated code)
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

<<<<<<< HEAD


=======
>>>>>>> 14b4245 (full updated code)
}
