<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi parameter filter halaman publik "Kegiatan".
 */
class EventFilterRequest extends FormRequest
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
            'waktu' => ['nullable', 'in:mendatang,selesai'],
        ];
    }

    public function period(): string
    {
        return $this->validated('waktu') ?? 'mendatang';
    }
}
