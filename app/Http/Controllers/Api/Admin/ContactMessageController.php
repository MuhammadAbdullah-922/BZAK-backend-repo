<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Display all contact messages
     */
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        // Search by name, email or subject
        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $messages = $query
            ->latest()
            ->paginate(10);

        return response()->json($messages);
    }

    /**
     * Show single message
     */
    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);

        // Mark as read
        if (!$message->is_read) {
            $message->is_read = true;
            $message->save();
        }

        return response()->json($message);
    }

    /**
     * Delete message
     */
    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id);

        $message->delete();

        return response()->json([
            'success' => true,
            'message' => 'Message deleted successfully.'
        ]);
    }

    /**
     * Dashboard unread messages count
     */
    public function unreadCount()
    {
        return response()->json([
            'count' => ContactMessage::where('is_read', false)->count()
        ]);
    }

    /**
     * Mark message as read manually
     */
    public function markAsRead($id)
    {
        $message = ContactMessage::findOrFail($id);

        $message->update([
            'is_read' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message marked as read.'
        ]);
    }
}