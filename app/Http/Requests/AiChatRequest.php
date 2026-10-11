<?php

namespace App\Http\Requests;

use App\Models\Child;
use Illuminate\Foundation\Http\FormRequest;

class AiChatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $childId = $this->input('child_id');
        if ($childId) {
            $child = Child::find($childId);
            if ($child) {
                abort_unless($child->user_id === $this->user()?->id, 403, 'Akses data anak tidak diizinkan.');
            }
        }

        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('user_message') && is_string($this->user_message)) {
            $trimmed = trim($this->user_message);
            $this->merge([
                'user_message' => $trimmed === '' ? null : $trimmed,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_message' => ['required', 'string', 'min:2', 'max:1000'],
            'child_id' => ['nullable', 'integer', 'exists:children,id'],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'user_message.required' => 'Pertanyaan wajib diisi sebelum mengirimkan pesan.',
            'user_message.string' => 'Format pertanyaan harus berupa teks.',
            'user_message.min' => 'Pertanyaan minimal terdiri dari 2 karakter.',
            'user_message.max' => 'Pertanyaan maksimal 1.000 karakter agar dapat diproses dengan baik.',
            'child_id.integer' => 'Pilihan anak tidak valid.',
            'child_id.exists' => 'Data anak tidak ditemukan.',
        ];
    }
}
