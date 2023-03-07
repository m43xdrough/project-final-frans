<?php

namespace App\Http\Requests;

use App\Models\MasterMaterial;
use App\Models\TransResep;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateTransSORequest extends FormRequest
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
            'soReceipt_Id'      => [
                'required',
                Rule::exists(TransResep::class, 'id')
            ],
            'soSubtotal'      => 'required|numeric',
            'soTotalDisc'       => 'required|numeric',
            'soTotalPPN'        => 'required|numeric',
            'soGrandTotal'    => 'required|numeric',
            'transdetail'               => 'required|array',
            'transdetail.*.itemNo'        => 'required|numeric',
            'transdetail.*.itemQty'           => 'required|numeric',
            'transdetail.*.itemPrice'         => 'required|numeric',
            'transdetail.*.itemDisc'          => 'required|numeric',
            'transdetail.*.itemNDisc'         => 'required|numeric',
            'transdetail.*.itemPPN'           => 'required|numeric',
            'transdetail.*.itemNPPN'          => 'required|numeric',
            'transdetail.*.itemTotal'         => 'required|numeric',
            'transdetail.*.itemCode'   => [
                'required',
                'string',
                /*'regex:​​/^[a-zA-Z0-9]+$/',*/
                Rule::exists(MasterMaterial::class, 'kdbarang')
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
