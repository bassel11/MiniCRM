<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;
class ClientController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('admin')) {
            $clients = Client::latest()->paginate(10);
        } elseif ($user->hasRole('manager')) {
            $clients = Client::latest()->paginate(10); // يمكن لاحقاً تخصيص بفريق المدير
        } else {
            $clients = Client::where('assigned_to', $user->id)->latest()->paginate(10);
        }

        return ClientResource::collection($clients);
    }

    // عرض عميل محدد
    public function show(Client $client)
    {
        $this->authorize('view', $client);
        return new ClientResource($client->load('assignedTo', 'communications', 'followUps'));
    }

    // إنشاء عميل جديد
    public function store(StoreClientRequest $request)
    {
        $client = Client::create($request->validated());
        return new ClientResource($client);
    }

    // تعديل عميل
    public function update(UpdateClientRequest $request, Client $client)
    {
        $this->authorize('update', $client);
        $client->update($request->validated());
        return new ClientResource($client);
    }

    // حذف عميل
    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);
        $client->delete();
        return response()->json(['message' => 'Client deleted successfully']);
    }
}
