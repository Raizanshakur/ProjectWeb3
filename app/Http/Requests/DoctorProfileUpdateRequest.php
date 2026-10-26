<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DoctorProfileUpdateRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna memiliki otorisasi untuk melakukan permintaan ini.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isDoctor();
    }

    /**
     * Persiapkan data sebelum validasi.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('name') && is_string($this->input('name'))) {
            $this->merge([
                'name' => trim($this->input('name')),
            ]);
        }

        if ($this->has('email') && is_string($this->input('email'))) {
            $this->merge([
                'email' => strtolower(trim($this->input('email'))),
            ]);
        }
    }

    /**
     * Dapatkan aturan validasi yang berlaku untuk permintaan ini.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->user();
        $doctor = $user?->doctor;
        $doctorId = $doctor?->id;
        $userId = $user?->id;

        return [
            'name'           => ['required', 'string', 'max:255'],
            'email'          => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
                Rule::unique('doctors', 'email')->ignore($doctorId),
            ],
            'specialization' => ['nullable', 'string', 'max:255'],
            'str_number'     => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('doctors', 'str_number')->ignore($doctorId),
            ],
            'phone'          => ['nullable', 'string', 'max:50'],
            'practice_days'  => ['nullable', 'string', 'max:255'],
            'start_time'     => ['nullable', 'date_format:H:i,H:i:s', 'required_with:end_time'],
            'end_time'       => ['nullable', 'date_format:H:i,H:i:s', 'after:start_time'],
            'bio'            => ['nullable', 'string', 'max:2000'],
            'is_available'   => ['sometimes', 'boolean'],
        ];
    }

    /**
     * Pesan kustom untuk validasi.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required'            => 'Nama lengkap dokter wajib diisi.',
            'email.required'           => 'Alamat email wajib diisi.',
            'email.email'              => 'Format alamat email tidak valid.',
            'email.unique'             => 'Alamat email ini sudah terdaftar oleh pengguna lain.',
            'str_number.unique'        => 'Nomor STR ini sudah terdaftar oleh dokter lain.',
            'start_time.required_with' => 'Jam mulai praktik wajib diisi jika jam selesai ditentukan.',
            'start_time.date_format'   => 'Format jam mulai tidak valid (contoh: 08:00).',
            'end_time.date_format'     => 'Format jam selesai tidak valid (contoh: 16:00).',
            'end_time.after'           => 'Jam selesai praktik harus lebih akhir daripada jam mulai.',
        ];
    }
}
