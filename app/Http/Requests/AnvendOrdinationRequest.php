<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnvendOrdinationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pnId' => 'required|integer',
            'date' => 'required|date',
        ];
    }
}