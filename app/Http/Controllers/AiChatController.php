<?php

namespace App\Http\Controllers;

use App\Exceptions\Gemini\GeminiApiKeyMissingException;
use App\Exceptions\Gemini\GeminiQuotaExceededException;
use App\Exceptions\Gemini\GeminiResponseException;
use App\Exceptions\Gemini\GeminiTimeoutException;
use App\Http\Requests\AiChatRequest;
use App\Models\Child;
use App\Models\Doctor;
use App\Services\AiChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AiChatController extends Controller
{
    public function __construct(
        protected AiChatService $aiChatService
    ) {
    }

    /**
     * Display the AI Chat interface with user's children and conversation history.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $children = $user->children()->oldest('id')->get();
        $selectedChild = null;

        if ($request->filled('child_id')) {
            $childId = (int) $request->input('child_id');
            $selectedChild = $children->firstWhere('id', $childId);

            if (! $selectedChild) {
                if (Child::where('id', $childId)->exists()) {
                    abort(403, 'Akses data anak tidak diizinkan.');
                }
                abort(404, 'Data anak tidak ditemukan.');
            }
        }

        $chats = $this->aiChatService->getUserChats($user, $selectedChild?->id);

        $availableDoctors = Doctor::with('user')
            ->available()
            ->get();

        return view('ai-chat', compact('children', 'selectedChild', 'chats', 'availableDoctors'));
    }

    /**
     * Process user's message with Gemini and persist response.
     */
    public function send(AiChatRequest $request): JsonResponse|RedirectResponse
    {
        $user = Auth::user();
        $userMessage = $request->validated('user_message');
        $childId = $request->validated('child_id');

        // Pencegahan concurrency & submit berulang per user
        $lock = Cache::lock("ai_chat_lock_{$user->id}", 15);
        if (! $lock->acquire()) {
            $msg = 'Permintaan sebelumnya sedang diproses. Mohon tunggu sejenak.';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 429);
            }
            return back()->withErrors(['ai_error' => $msg]);
        }

        try {
            $chat = $this->aiChatService->sendMessage($user, $userMessage, $childId);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'chat' => [
                        'id' => $chat->id,
                        'user_message' => $chat->user_message,
                        'ai_response' => $chat->ai_response,
                        'created_at' => $chat->created_at->format('H:i'),
                        'model_used' => $chat->model_used,
                    ],
                ], 201);
            }

            return redirect()
                ->route('ai.chat', array_filter(['child_id' => $childId]))
                ->with('success', 'Pertanyaan berhasil dijawab oleh NutriBot.');

        } catch (GeminiApiKeyMissingException $e) {
            $msg = 'Kunci API Gemini belum dikonfigurasi di server. Silakan hubungi pengelola aplikasi.';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 503);
            }
            return back()->withErrors(['ai_error' => $msg]);

        } catch (GeminiQuotaExceededException $e) {
            $msg = 'Batas kuota layanan Gemini tercapai (429). Silakan coba lagi beberapa saat lagi.';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 429);
            }
            return back()->withErrors(['ai_error' => $msg]);

        } catch (GeminiTimeoutException $e) {
            $msg = 'Waktu permintaan analisis ke AI habis (timeout). Silakan periksa koneksi dan coba lagi.';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 504);
            }
            return back()->withErrors(['ai_error' => $msg]);

        } catch (GeminiResponseException $e) {
            $msg = 'Layanan Gemini AI sedang mengalami kendala. Silakan coba lagi beberapa saat lagi.';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 502);
            }
            return back()->withErrors(['ai_error' => $msg]);

        } catch (\Throwable $e) {
            Log::error('AiChat unexpected error', ['error' => $e->getMessage()]);
            $msg = 'Terjadi kesalahan sistem saat memproses pertanyaan Anda.';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 500);
            }
            return back()->withErrors(['ai_error' => $msg]);
        } finally {
            $lock->release();
        }
    }

    /**
     * Clear chat history belonging to the authenticated user.
     */
    public function clear(Request $request): JsonResponse|RedirectResponse
    {
        $user = Auth::user();
        $childId = null;

        if ($request->filled('child_id')) {
            $childId = (int) $request->input('child_id');
            $child = $user->children()->find($childId);
            if (! $child) {
                if (Child::where('id', $childId)->exists()) {
                    abort(403, 'Akses data anak tidak diizinkan.');
                }
                abort(404, 'Data anak tidak ditemukan.');
            }
        }

        $deletedCount = $this->aiChatService->clearUserHistory($user, $childId);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Riwayat percakapan berhasil dibersihkan ($deletedCount pesan).",
            ]);
        }

        return redirect()
            ->route('ai.chat', array_filter(['child_id' => $childId]))
            ->with('success', 'Riwayat percakapan berhasil dihapus.');
    }
}
