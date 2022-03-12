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
    public const AGE_GTE = 0;
    public const DEPENDENTS_GTE = 0;
    public const INCOME_GTE = 0;
    public const RISK_QUESTIONS_SIZE = 3;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'age' => ['required', 'integer', 'gte:' . self::AGE_GTE],
            'dependents' => ['required', 'integer', 'gte:' . self::DEPENDENTS_GTE],
            'house' => ['present', 'array'],
            'house.ownership_status' => ['string', Rule::in(HouseEnum::all())],
            'income' => ['required', 'integer', 'gte:' . self::INCOME_GTE],
            'marital_status' => ['required', Rule::in(MaritalStatusEnum::all())],
            'risk_questions' => ['required', 'array', 'size:' . self::RISK_QUESTIONS_SIZE],
            'risk_questions.*' => ['bool'],
            'vehicle' => ['present', 'array'],
            'vehicle.year' => ['integer', 'between:' . implode(',', [self::FIRST_CAR_YEAR, Carbon::today()->year])],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->json()->all()) {
            $this->merge(
                json_decode($this->getContent(), true)
            );
        }

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
