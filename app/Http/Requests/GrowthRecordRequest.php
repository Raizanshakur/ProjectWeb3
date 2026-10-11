<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GrowthRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $child = $this->route('child');
        abort_unless($child && $child->user_id === $this->user()?->id, 403);

        $record = $this->route('record');
        if ($record) {
            abort_unless($record->child_id === $child->id, 404);
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
        $child = $this->route('child');
        $minDate = ($child && $child->birth_date)
            ? $child->birth_date->format('Y-m-d')
            : null;

        $dateRules = ['required', 'date', 'before_or_equal:today'];
        if ($minDate) {
            $dateRules[] = 'after_or_equal:' . $minDate;
        }

        return [
            'measurement_date' => $dateRules,
            'weight' => ['required', 'numeric', 'min:0.1', 'max:200'],
            'height' => ['required', 'numeric', 'min:1', 'max:250'],
            'head_circumference' => ['nullable', 'numeric', 'min:1', 'max:100'],
            'nutrition_status' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Custom message for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'measurement_date.required' => 'Tanggal pengukuran wajib diisi.',
            'measurement_date.date' => 'Format tanggal pengukuran tidak valid.',
            'measurement_date.before_or_equal' => 'Tanggal pengukuran tidak boleh melebihi hari ini.',
            'measurement_date.after_or_equal' => 'Tanggal pengukuran tidak boleh sebelum tanggal lahir anak.',
            'weight.required' => 'Berat badan wajib diisi.',
            'weight.numeric' => 'Berat badan harus berupa angka.',
            'weight.min' => 'Berat badan minimal 0.1 kg.',
            'weight.max' => 'Berat badan maksimal 200 kg.',
            'height.required' => 'Tinggi badan wajib diisi.',
            'height.numeric' => 'Tinggi badan harus berupa angka.',
            'height.min' => 'Tinggi badan minimal 1 cm.',
            'height.max' => 'Tinggi badan maksimal 250 cm.',
            'head_circumference.numeric' => 'Lingkar kepala harus berupa angka.',
            'head_circumference.min' => 'Lingkar kepala minimal 1 cm.',
            'head_circumference.max' => 'Lingkar kepala maksimal 100 cm.',
            'notes.max' => 'Catatan maksimal 1000 karakter.',
        ];
    }
}
