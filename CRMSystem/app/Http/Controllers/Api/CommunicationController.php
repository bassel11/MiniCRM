<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommunicationRequest;
use App\Http\Resources\CommunicationResource;
use App\Models\Client;
use App\Models\Communication;
use Illuminate\Http\Request;

class CommunicationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('admin')) {
            $communications = Communication::with(['client', 'creator'])
                ->latest()->paginate(10);
        } elseif ($user->hasRole('manager')) {
            $communications = Communication::with(['client', 'creator'])
                ->latest()->paginate(10);
        } else {
            $communications = Communication::with(['client', 'creator'])
                ->where('created_by', $user->id)
                ->latest()->paginate(10);
        }

        return CommunicationResource::collection($communications);
    }

    // إنشاء سجل تواصل جديد
    public function store(StoreCommunicationRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;

        $communication = Communication::create($data);

        // سيتم تحديث آخر تواصل تلقائيًا من داخل Model booted()
        // وسيُشغّل Event CommunicationCreated
        event(new \App\Events\CommunicationCreated($communication));

        return new CommunicationResource($communication);
    }
}
