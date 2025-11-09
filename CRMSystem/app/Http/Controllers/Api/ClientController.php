<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientResource;

class ClientController extends Controller
{
    /**
     * Display a listing of the clients.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('admin')) {
            $clients = Client::latest()->paginate(10);
        } elseif ($user->hasRole('manager')) {
            // لاحقًا يمكن تخصيص العملاء حسب فريق المدير
            $clients = Client::latest()->paginate(10);
        } else {
            $clients = Client::where('assigned_to', $user->id)
                ->latest()
                ->paginate(10);
        }

        return ClientResource::collection($clients);
    }

    /**
     * Store a newly created client.
     */
    public function store(StoreClientRequest $request)
    {
        $client = Client::create($request->validated());
        return new ClientResource($client);
    }

    /**
     * Display the specified client.
     */
    public function show(Client $client)
    {
        $this->authorize('view', $client);
        return new ClientResource($client->load('assignedTo','communications','followUps'));
    }

    /**
     * Update the specified client.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $this->authorize('update', $client);
        $client->update($request->validated());
        return new ClientResource($client);
    }

    /**
     * Remove the specified client.
     */
    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);
        $client->delete();

        return response()->json(['message' => 'Client deleted successfully']);
    }
}
