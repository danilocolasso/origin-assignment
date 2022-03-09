<?php

namespace App\Http\Requests;

use App\Enums\MaritalStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InsuranceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'age' => ['required', 'gte:0'],
            'dependents' => ['required', 'gte:0'],
            'house' => 'required',
            'income' => ['required', 'gte:0'],
            'marital_status' => ['required', Rule::in(MaritalStatusEnum::all())],
            'risk_questions' => ['required', 'array'],
            'risk_questions.*' => 'bool',
            'vehicle' => 'required',
        ];
    }

    /**
     * Prepare inputs for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'risk_questions' => $this->filterArrayBoolElements($this->get('risk_questions')),
        ]);
    }

    private function filterArrayBoolElements(mixed $values): mixed
    {
        if (is_array($values)) {
            foreach ($values as &$value) {
                $value = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            }
        }

        return $values;
    }
}
