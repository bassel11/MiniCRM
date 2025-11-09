<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommunicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'type' => 'required|in:call,email,meeting',
            'date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ];
    }
}
