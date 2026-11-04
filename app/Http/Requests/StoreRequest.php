<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $storeId = $this->route('store')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('stores', 'slug')->ignore($storeId)],
            'tagline' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'description' => ['nullable', 'string'],
            'announcement' => ['nullable', 'string', 'max:500'],
            'facilities' => ['nullable', 'array'],
            'facilities.*' => ['string', 'max:50'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:500'],
            'maps_url' => ['nullable', 'string', 'max:500'],
            'instagram' => ['nullable', 'string', 'max:100'],
            'opening_hours' => ['nullable', 'string', 'max:150'],
            'is_open' => ['nullable', 'boolean'],
            'category' => ['nullable', 'string', 'max:100'],
            'theme_color' => ['nullable', 'string', 'max:20'],
        ];
    }
}
