<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMotorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'plate_number' => ['required', 'string', 'max:50', 'unique:motors'],
            'brand' => ['required', 'string', 'max:255'],
            'battery_capacity' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'in:available,in_use,maintenance'],
            'is_active' => ['boolean'],
        ];
    }
}
