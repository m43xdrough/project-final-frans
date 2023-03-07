<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
    */
    public function rules(): array
    {
        return [
            'userName'     => 'required|max:255',
            'userEmail'    => 'required|max:255',
            'userPassword' => 'required|max:255',
        ];
    }

    /**
     * Override the failedVaildation to a new response format when validation failed.
    */
    protected function failedValidation(Validator $validator): object
    {
        throw new HttpResponseException(
            response()->json([
                'errors' => $validator->errors(),
                'request' => $this->input(),
            ], 422)
        );
    }
}
