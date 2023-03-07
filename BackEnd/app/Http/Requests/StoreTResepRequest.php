<?php

namespace App\Http\Requests;

use App\Models\MasterMember;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;


class StoreTResepRequest extends FormRequest
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
            // 'tglresep'      => 'required|date',
            // 'noresep'       => [
            //     'min:5',
            //     'max:15',
            //     'required',
            //     Rule::unique('tresep', 'noresep')
            //         //->ignore($this->noresep)
            //         ->where('tglresep', $this->tglresep)
            //         ->where('noresep', $this->noresep)

            // ],

            'receiptSpherisr'    => 'required|max:10',
            'receiptSpherisl'    => 'required|max:10',
            'receiptCylinderr'   => 'required|max:10',
            'receiptCylinderl'   => 'required|max:10',
            'receiptAdditionr'   => 'max:10',
            'receiptAdditionl'   => 'max:10',
            'receiptAxisr'       => 'max:10',
            'receiptAxisl'       => 'max:10',
            'receiptMemberID'     => [
                'required',
                Rule::exists(MasterMember::class, 'id')
            ]
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
