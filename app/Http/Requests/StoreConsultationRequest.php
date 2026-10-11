<?php

namespace App\Http\Requests;

use App\Models\Child;
use App\Models\Doctor;
use Illuminate\Foundation\Http\FormRequest;

class StoreConsultationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $childId = $this->input('child_id');
        if ($childId) {
            $child = Child::find($childId);
            // Anak bukan milik sendiri -> 403
            if ($child && $child->user_id !== $this->user()?->id) {
                abort(403, 'Anda tidak memiliki hak akses untuk anak ini.');
            }
        }

        return $this->user()?->isParent() ?? false;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('complaint') && is_string($this->input('complaint'))) {
            $this->merge([
                'complaint' => trim($this->input('complaint')),
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
            'child_id' => [
                'required',
                'integer',
                'exists:children,id',
            ],
            'doctor_id' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    $doctor = Doctor::with('user')->find($value);
                    if (! $doctor || ! $doctor->is_available || ! $doctor->user || $doctor->user->role !== 'doctor') {
                        $fail('Dokter yang dipilih tidak valid atau sedang tidak tersedia.');
                    }
                },
            ],
            'complaint' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
            'consultation_date' => [
                'nullable',
                'date',
                'after_or_equal:today',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'child_id.required' => 'Silakan pilih anak untuk konsultasi.',
            'child_id.exists' => 'Data anak tidak ditemukan.',
            'doctor_id.required' => 'Silakan pilih dokter spesialis anak.',
            'doctor_id.exists' => 'Data dokter tidak ditemukan.',
            'complaint.required' => 'Keluhan konsultasi wajib diisi.',
            'complaint.min' => 'Keluhan minimal 10 karakter.',
            'complaint.max' => 'Keluhan maksimal 2000 karakter.',
            'consultation_date.after_or_equal' => 'Tanggal konsultasi tidak boleh di masa lalu.',
        ];
    }
}
