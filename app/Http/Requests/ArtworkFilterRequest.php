<?php

namespace App\Http\Requests;

use App\Models\Artwork;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validasi parameter filter halaman publik "Karya Seni".
 */
class ArtworkFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'kategori' => ['nullable', 'string', Rule::in(array_keys(Artwork::CATEGORIES))],
            'q' => ['nullable', 'string', 'max:100'],
        ];
    }
}
