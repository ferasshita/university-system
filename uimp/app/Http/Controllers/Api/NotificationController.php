<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationHistoryResource;
use App\Models\NotificationHistory;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $query = NotificationHistory::with('template')->where('user_id', Auth::id());

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return NotificationHistoryResource::collection($query->paginate(15));
    }

    public function send(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'template_slug' => 'required|string|exists:notification_templates,slug',
            'placeholders' => 'nullable|array',
            'channel' => 'nullable|string|in:email,in_app,sms',
        ]);

        $user = User::find($request->user_id);
        $this->notificationService->send(
            $user,
            $request->template_slug,
            $request->placeholders ?? [],
            $request->channel
        );

        return response()->json(['message' => 'Notification sent (queued).']);
    }
}
