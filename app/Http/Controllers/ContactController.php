<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\User;
use App\Notifications\NewContactMessageNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * POST /api/contact
     * Stores an incoming contact form message.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'subject' => 'required|string|max:150',
            'message' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $contactMessage = ContactMessage::create($validator->validated());

        // 👇 Admin ko email notification bhej rahe hain
        $admin = User::where('email', 'admin@bzak.com')->first();

        if ($admin) {
            $admin->notify(new NewContactMessageNotification($contactMessage));
        }

        return response()->json([
            'message' => 'Your message has been sent successfully.',
            'data'    => $contactMessage,
        ], 201);
    }
}