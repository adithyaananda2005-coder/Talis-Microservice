<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return response()->json([
            'status'  => 'Success',
            'message' => 'Notifications retrieved successfully',
            'data'    => Notification::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'      => 'required|string',
            'recipient' => 'required|string',
            'message'   => 'required|string',
        ]);

        $notification = Notification::create([
            'type'      => $request->type,
            'recipient' => $request->recipient,
            'message'   => $request->message,
            'status'    => 'sent',
        ]);

        return response()->json([
            'status'  => 'Success',
            'message' => 'Notification sent successfully',
            'data'    => $notification
        ], 201);
    }

    public function show($id)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            return response()->json([
                'status'  => 'Failed',
                'message' => 'Notification not found',
                'data'    => null
            ], 404);
        }

        return response()->json([
            'status'  => 'Success',
            'message' => 'Notification found',
            'data'    => $notification
        ]);
    }

    public function destroy($id)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            return response()->json([
                'status'  => 'Failed',
                'message' => 'Notification not found',
                'data'    => null
            ], 404);
        }

        $notification->delete();

        return response()->json([
            'status'  => 'Success',
            'message' => 'Notification deleted successfully',
            'data'    => null
        ]);
    }

    public function getByRecipient($recipient)
    {
        $notifications = Notification::where('recipient', $recipient)->get();

        return response()->json([
            'status'  => 'Success',
            'message' => 'Notifications retrieved successfully',
            'data'    => $notifications
        ]);
    }
}