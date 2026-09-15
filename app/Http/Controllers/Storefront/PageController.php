<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PageController extends Controller
{
    public function about()
    {
        return view('storefront.pages.about');
    }

    public function contact()
    {
        return view('storefront.pages.contact');
    }

    public function storeContact(ContactRequest $request)
    {
        ContactMessage::create($request->validated());

        return back()->with('success', 'Thank you for contacting Gauri Suits & Jewel. Our concierge team will get back to you shortly.');
    }

    public function faq()
    {
        return view('storefront.pages.faq');
    }

    public function subscribeNewsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $email = trim(strtolower($request->input('email')));

        NewsletterSubscriber::updateOrCreate(
            ['email' => $email],
            ['is_active' => true, 'subscribed_at' => Carbon::now()]
        );

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Welcome to the Gauri Community! You have successfully subscribed to our royal updates.',
            ]);
        }

        return back()->with('success', 'Welcome to the Gauri Community! You have successfully subscribed to our royal updates.');
    }

    public function shippingPolicy()
    {
        return view('storefront.pages.shipping-policy');
    }

    public function returnPolicy()
    {
        return view('storefront.pages.return-policy');
    }

    public function refundPolicy()
    {
        return view('storefront.pages.refund-policy');
    }

    public function privacyPolicy()
    {
        return view('storefront.pages.privacy-policy');
    }

    public function termsAndConditions()
    {
        return view('storefront.pages.terms');
    }
}
