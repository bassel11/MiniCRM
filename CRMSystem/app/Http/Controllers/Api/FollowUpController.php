<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFollowUpRequest;
use App\Http\Resources\FollowUpResource;
use App\Models\FollowUp;
use Illuminate\Http\Request;
use App\Notifications\FollowUpDueNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FollowUpController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('admin')) {
            $followUps = FollowUp::with(['client', 'user'])->latest()->paginate(10);
        } elseif ($user->hasRole('manager')) {
            $followUps = FollowUp::with(['client', 'user'])->latest()->paginate(10);
        } else {
            $followUps = FollowUp::where('user_id', $user->id)
                ->with(['client', 'user'])
                ->latest()->paginate(10);
        }

        return FollowUpResource::collection($followUps);
    }

    // إنشاء متابعة جديدة
    public function store(StoreFollowUpRequest $request)
    {
        if (!$request->user()->can('create', FollowUp::class)) {
            abort(403);
        }

        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $followUp = FollowUp::create($data);

        // إرسال إشعار مؤجل عبر Queue (يمكن تشغيل queue worker)
        $followUp->user->notify(new FollowUpDueNotification($followUp));

        return new FollowUpResource($followUp);
    }

    // عرض متابعة محددة
    public function show(FollowUp $followUp)
    {
        $this->authorize('view', $followUp);

        return new FollowUpResource($followUp->load(['client','user']));
    }
}
