<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateTResepRequest extends FormRequest
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
            'receiptSpherisr'    => 'required|max:10',
            'receiptSpherisl'    => 'required|max:10',
            'receiptCylinderr'   => 'required|max:10',
            'receiptCylinderl'   => 'required|max:10',
            'receiptAdditionr'   => 'max:10',
            'receiptAdditionl'   => 'max:10',
            'receiptAxisr'       => 'max:10',
            'receiptAxisl'       => 'max:10',
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
