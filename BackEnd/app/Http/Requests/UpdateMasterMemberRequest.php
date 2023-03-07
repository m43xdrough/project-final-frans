<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateMasterMemberRequest extends FormRequest
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
            'memberName'          => 'required|max:200',
            'memberBirthdate'     => 'required|date',
            'memberSex'           => 'in:L,P',
            'memberPassword'      => ['min:8', 'max:20'],
            'memberAddress'       => 'required|max:200',
            'memberCity'          => 'max:100',
            'memberProvince'      => 'max:100',
            'memberEmail'         => 'email|max:200',
            'memberPhone'         => 'max:20'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(
                GeneratePayload([400, $validator->errors()])
            ),
            400
        );
    }
}
