<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use illuminate\Validation\Rule;
use illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Validation\Rules\In;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'name' => ['required'],
            'type' => ['required', $this->in(['B', 'b', 'I', 'i'])],
            'email' => ['required', 'email'],
            'address' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'postalCode' => ['required']
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'postal_code' => $this->postalCode
        ]);
    }

    public static function in($values)
    {
        if ($values instanceof Arrayable) {
            $values = $values->toArray();
        }

        return new In(is_array($values) ? $values : func_get_args());
    }
}
