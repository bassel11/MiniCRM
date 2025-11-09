<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFollowUpRequest;
use App\Http\Resources\FollowUpResource;
use App\Models\Client;
use App\Models\FollowUp;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FollowUpController extends Controller
{
    use AuthorizesRequests;

    // عرض جميع المتابعات حسب الدور
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('admin')) {
            $followUps = FollowUp::with(['client','user'])->latest()->paginate(10);
        } elseif ($user->hasRole('manager')) {
            $followUps = FollowUp::with(['client','user'])->latest()->paginate(10);
            // يمكن لاحقًا تقييد حسب فريق المدير
        } else { // sales_rep
            $followUps = FollowUp::with(['client','user'])
                ->where('user_id', $user->id)
                ->latest()->paginate(10);
        }

        return FollowUpResource::collection($followUps);
    }

    // عرض متابعة واحدة
    public function show(FollowUp $follow_up)
    {
        $this->authorize('view', $follow_up);
        return new FollowUpResource($follow_up->load(['client','user']));
    }

    // إنشاء متابعة جديدة
    public function store(StoreFollowUpRequest $request, Client $client)
    {
        $user = $request->user();

        // الصلاحية: فقط Manager أو Sales Rep على العملاء المخصصين لهم
        if ($user->hasRole('sales_rep') && $client->assigned_to !== $user->id) {
            return response()->json(['message' => 'Forbidden. Cannot create follow-up for this client.'], 403);
        }

        // إنشاء Follow-up
        $followUp = FollowUp::create([
            'client_id' => $client->id,
            'user_id' => $user->id,
            'due_at' => $request->due_at,
            'notes' => $request->notes,
            'done' => false,
        ]);

        // إرسال إشعار (Notification) اختياري
        $user->notify(new \App\Notifications\FollowUpDueNotification($followUp));

        return new FollowUpResource($followUp);
    }
}
