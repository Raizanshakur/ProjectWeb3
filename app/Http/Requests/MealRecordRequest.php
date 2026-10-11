<?php

namespace App\Http\Requests;

use App\Models\Child;
use App\Models\MealRecord;
use Illuminate\Foundation\Http\FormRequest;

class MealRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $childParam = $this->route('child');
        $childId = $this->input('child_id') ?? ($childParam instanceof Child ? $childParam->id : $childParam);
        if ($childId) {
            $child = $childParam instanceof Child ? $childParam : Child::find($childId);
            abort_unless($child && $child->user_id === $this->user()?->id, 403);
        }

        $record = $this->route('meal') ?? $this->route('meal_record');
        if ($record) {
            if (! ($record instanceof MealRecord)) {
                $record = MealRecord::find($record);
            }
            abort_unless($record && $record->user_id === $this->user()?->id, 403);
            if ($childId) {
                abort_unless($record->child_id == $childId, 404);
            }
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
        $childParam = $this->route('child');
        $childId = $this->input('child_id') ?? ($childParam instanceof Child ? $childParam->id : $childParam);
        $child = $childParam instanceof Child ? $childParam : ($childId ? Child::find($childId) : null);
        if (! $child) {
            $record = $this->route('meal') ?? $this->route('meal_record');
            if ($record) {
                if (! ($record instanceof MealRecord)) {
                    $record = MealRecord::find($record);
                }
                $child = $record?->child;
            }
        }
        $minDate = ($child && $child->birth_date) ? $child->birth_date->format('Y-m-d') : null;

        $dateRules = ['required', 'date', 'before_or_equal:now'];
        if ($minDate) {
            $dateRules[] = 'after_or_equal:' . $minDate;
        }

        $requireChildId = $this->isMethod('POST') && ! $this->route('child');

        return [
            'child_id' => [$requireChildId ? 'required' : 'nullable', 'integer', 'exists:children,id'],
            'food_name' => ['required', 'string', 'max:255'],
            'meal_type' => ['required', 'string', 'max:50'],
            'portion_text' => ['nullable', 'string', 'max:100'],
            'consumed_at' => $dateRules,
            'calories' => ['nullable', 'numeric', 'min:0', 'max:10000'],
            'protein' => ['nullable', 'numeric', 'min:0', 'max:1000'],
            'carbohydrates' => ['nullable', 'numeric', 'min:0', 'max:1000'],
            'fat' => ['nullable', 'numeric', 'min:0', 'max:1000'],
            'fiber' => ['nullable', 'numeric', 'min:0', 'max:500'],
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
            'child_id.required' => 'Pilihan anak wajib diisi.',
            'child_id.exists' => 'Data anak tidak ditemukan.',
            'food_name.required' => 'Nama makanan wajib diisi.',
            'meal_type.required' => 'Waktu / jenis makan wajib diisi.',
            'consumed_at.required' => 'Waktu konsumsi wajib diisi.',
            'consumed_at.before_or_equal' => 'Waktu konsumsi tidak boleh di masa depan.',
            'consumed_at.after_or_equal' => 'Waktu konsumsi tidak boleh sebelum tanggal lahir anak.',
            'calories.numeric' => 'Kalori harus berupa angka.',
            'calories.min' => 'Kalori tidak boleh bernilai negatif.',
            'calories.max' => 'Kalori melebihi batas wajar.',
            'protein.numeric' => 'Protein harus berupa angka.',
            'protein.min' => 'Protein tidak boleh bernilai negatif.',
            'carbohydrates.numeric' => 'Karbohidrat harus berupa angka.',
            'carbohydrates.min' => 'Karbohidrat tidak boleh bernilai negatif.',
            'fat.numeric' => 'Lemak harus berupa angka.',
            'fat.min' => 'Lemak tidak boleh bernilai negatif.',
            'fiber.numeric' => 'Serat harus berupa angka.',
            'fiber.min' => 'Serat tidak boleh bernilai negatif.',
        ];
    }
}
