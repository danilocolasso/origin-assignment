<?php

namespace App\Http\Requests;

use App\Enums\HouseEnum;
use App\Enums\MaritalStatusEnum;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InsuranceRequest extends FormRequest
{
    public const FIRST_CAR_YEAR = 1884;

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
            'age' => ['required', 'integer', 'gte:0'],
            'dependents' => ['required', 'integer', 'gte:0'],
            'house' => ['present', 'array'],
            'house.ownership_status' => ['string', Rule::in(HouseEnum::all())],
            'income' => ['required', 'integer', 'gte:0'],
            'marital_status' => ['required', Rule::in(MaritalStatusEnum::all())],
            'risk_questions' => ['required', 'array', 'min:3'],
            'risk_questions.*' => ['bool'],
            'vehicle' => ['present', 'array'],
            'vehicle.year' => ['integer', 'between:' . implode(',', [self::FIRST_CAR_YEAR, Carbon::today()->year])],
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
