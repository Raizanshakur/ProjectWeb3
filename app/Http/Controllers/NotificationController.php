<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NotificationController extends Controller
{
    /**
     * Ambil ringkasan daftar notifikasi akun pengguna yang sedang login.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $notifications = $user->notifications()
            ->latest()
            ->take(15)
            ->get()
            ->map(function ($n) {
                $diffInSeconds = abs(Carbon::now()->diffInSeconds($n->created_at));
                $timeAgo = $diffInSeconds < 60
                    ? 'Baru saja'
                    : $n->created_at->locale('id')->diffForHumans();

                return [
                    'id'              => $n->id,
                    'type'            => $n->data['type'] ?? 'system',
                    'title'           => $n->data['title'] ?? 'Pemberitahuan',
                    'message'         => $n->data['message'] ?? '',
                    'action_url'      => $n->data['action_url'] ?? null,
                    'icon'            => $n->data['icon'] ?? 'bell',
                    'category'        => $n->data['category'] ?? 'general',
                    'read'            => $n->read(),
                    'created_at_time' => $n->created_at->format('H:i'),
                    'time_ago'        => $timeAgo,
                ];
            });

        return response()->json([
            'unread_count'  => $user->unreadNotifications()->count(),
            'notifications' => $notifications,
        ]);
    }

    /**
     * Endpoint ringan untuk polling jumlah notifikasi belum dibaca.
     */
    public function unreadCount(Request $request): JsonResponse
    {
        return response()->json([
            'unread_count' => $request->user()->unreadNotifications()->count(),
        ]);
    }

    /**
     * Tandai satu notifikasi sebagai telah dibaca dan arahkan ke tujuan yang aman.
     */
    public function read(Request $request, string $id): JsonResponse|RedirectResponse
    {
        $user = $request->user();

        $notification = $user->notifications()->where('id', $id)->firstOrFail();

        if ($notification->unread()) {
            $notification->markAsRead();
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success'      => true,
                'unread_count' => $user->unreadNotifications()->count(),
            ]);
        }

        $targetUrl = $notification->data['action_url'] ?? null;

        // Validasi keamanan URL internal agar tidak terjadi open redirect
        if ($targetUrl && (str_starts_with($targetUrl, url('/')) || str_starts_with($targetUrl, '/'))) {
            return redirect()->to($targetUrl);
        }

        return redirect()->back();
    }

    /**
     * Tandai seluruh notifikasi yang belum dibaca milik pengguna saat ini sebagai telah dibaca.
     */
    public function readAll(Request $request): JsonResponse|RedirectResponse
    {
        $user = $request->user();

        $user->unreadNotifications->markAsRead();

        if ($request->wantsJson()) {
            return response()->json([
                'success'      => true,
                'unread_count' => 0,
            ]);
        }

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }
}
