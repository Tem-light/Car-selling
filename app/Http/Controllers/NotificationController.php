<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = $request->user()->notifications()->latest();

        if ($request->boolean('unread_only')) {
            $query->whereNull('read_at');
        }

        $notifications = $query->limit(20)->get();
        $unreadCount = $request->user()->notifications()->whereNull('read_at')->count();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'notifications' => $notifications,
                'unread_count'  => $unreadCount,
            ]);
        }

        return view('notifications.index', [
            'notifications' => $notifications,
            'unreadCount'   => $unreadCount,
        ]);
    }

    public function markAsRead(UserNotification $notification, Request $request)
    {
        if ($notification->user_id !== $request->user()->id) {
            abort(403);
        }
        $notification->markAsRead();
        $unreadCount = $request->user()->notifications()->whereNull('read_at')->count();
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['ok' => true, 'unread_count' => $unreadCount]);
        }
        return back();
    }

    public function markAllAsRead(Request $request)
    {
        $request->user()->notifications()->whereNull('read_at')->update(['read_at' => now()]);
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['ok' => true, 'unread_count' => 0]);
        }
        return back();
    }
}
