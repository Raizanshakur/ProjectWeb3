<?php

namespace App\Http\Requests;

use App\Models\Child;
use Illuminate\Foundation\Http\FormRequest;

class FoodScanUploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $childId = $this->input('child_id');
        if ($childId) {
            $child = Child::find($childId);
            abort_unless($child && $child->user_id === $this->user()?->id, 403);
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => [
                'required',
                'file',
                'image',
                'min:1',
                'mimetypes:image/jpeg,image/png,image/webp',
                'max:5120', // max 5MB
            ],
            'child_id' => [
                'nullable',
                'integer',
                'exists:children,id',
            ],
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'image.required' => 'Foto makanan wajib diunggah.',
            'image.file' => 'Berkas yang diunggah harus berupa file.',
            'image.image' => 'Berkas yang diunggah harus berupa gambar yang valid.',
            'image.min' => 'Berkas gambar tidak boleh kosong (minimal 1 KB).',
            'image.mimetypes' => 'Format foto harus berupa JPG, PNG, atau WebP.',
            'image.max' => 'Ukuran foto maksimal adalah 5 MB.',
            'child_id.exists' => 'Data anak tidak ditemukan.',
        ];
    }
}
