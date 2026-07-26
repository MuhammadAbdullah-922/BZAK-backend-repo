<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsletterSubscriber;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email',
        ]);

        NewsletterSubscriber::create([
            'email' => $request->email,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subscribed successfully!',
        ]);
    }
    public function index()
{
    return NewsletterSubscriber::latest()->get();
}
public function destroy($id)
{
    NewsletterSubscriber::findOrFail($id)->delete();

    return response()->json([
        'message' => 'Subscriber deleted successfully'
    ]);
}
}