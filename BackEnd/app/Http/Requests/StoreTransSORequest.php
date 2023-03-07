<?php

namespace App\Http\Requests;

use App\Models\TransResep;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;


class StoreTransSORequest extends FormRequest
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
            /*'tgltrans'      => 'required|date',
            'notrans'       => [
                'min:5',
                'max:15',
                'required',
                Rule::unique('tsoh', 'notrans')
                    //->ignore($this->notrans)
                    ->where('tgltrans', $this->tgltrans)
                    ->where('notrans', $this->notrans)
            ],*/
            'soReceipt_Id'      => [
                'required',
                Rule::exists(TransResep::class, 'id')
            ],
            'soSubtotal'      => 'required|numeric',
            'soTotalDisc'       => 'required|numeric',
            'soTotalPPN'        => 'required|numeric',
            'soGrandTotal'    => 'required|numeric',
            /*'transdetail'               => 'required|array',
            'transdetail.itemNo'        => 'required|numeric',
            'transdetail.itemQty'           => 'required|numeric',
            'transdetail.itemPrice'         => 'required|numeric',
            'transdetail.itemDisc'          => 'required|numeric',
            'transdetail.itemNDisc'         => 'required|numeric',
            'transdetail.itemPPN'           => 'required|numeric',
            'transdetail.itemNPPN'          => 'required|numeric',
            'transdetail.itemTotal'         => 'required|numeric',
            'transdetail.itemCode'   => [
                'required',
                'string',
                'regex:​​/^[0-9]+$/', //'regex:​​/^[a-zA-Z0-9]+$/' //validasi untuk Numeric tapi tipenya string
                Rule::exists(MasterMaterial::class, 'id')
            ]*/
        ];
    }
    /*
    public function messages()
    {
        return [
            'tgltrans.required' => 'Tgl Trans could not be blank',
            'tgltrans.numeric' => 'Tgl Trans must be numeric',

            'notrans.required' => 'No Trans could not be blank',
            'notrans.min' => 'No Trans minimum length is 5 characters.',
            'notrans.max' => 'No Trans maximum length is 15 characters.',
            'notrans.unique' => 'No Trans already registered.',

            'resep_id.required' => 'Resep ID could not be blank',
            'resep_id.exist' => 'Resep ID not exist on Master',

            'soSubtotal.required' => 'Sub Total could not be blank',
            'soSubtotal.numeric' => 'Sub Total must be numeric',

            'soTotalDisc.required' => 'Total Disc could not be blank',
            'soTotalDisc.numeric' => 'Total Disc must be numeric',

            'soTotalPPN.required' => 'Total PPN could not be blank',
            'soTotalPPN.numeric' => 'Total PPN must be numeric',

            'soGrandTotal.required' => 'Grand Total could not be blank',
            'soGrandTotal.numeric' => 'Grand Total must be numeric',

            'transdetail.required' => 'Detail Data could not be blank',
            'transdetail.array' => 'Detail Data must be array',

            'transdetail.itemNo.required' => 'Trans Detail No. Urut could not be blank',
            'transdetail.itemNo.numeric' => 'Trans Detail No. Urut must be numeric',

            'transdetail.itemQty.required' => 'Trans Detail Qty could not be blank',
            'transdetail.itemQty.numeric' => 'Trans Detail Qty must be numeric',

            'transdetail.itemPrice.required' => 'Trans Detail Harga could not be blank',
            'transdetail.itemPrice.numeric' => 'Trans Detail Harga must be numeric',

            'transdetail.itemDisc.required' => 'Trans Detail Discount could not be blank',
            'transdetail.itemDisc.numeric' => 'Trans Detail Discount must be numeric',

            'transdetail.itemNDisc.required' => 'Trans Detail N Discount could not be blank',
            'transdetail.itemNDisc.numeric' => 'Trans Detail N Discount must be numeric',

            'transdetail.itemPPN.required' => 'Trans Detail PPN could not be blank',
            'transdetail.itemPPN.numeric' => 'Trans Detail PPN must be numeric',

            'transdetail.itemNPPN.required' => 'Trans Detail N PPN could not be blank',
            'transdetail.itemNPPN.numeric' => 'Trans Detail N PPN must be numeric',

            'transdetail.itemTotal.required' => 'Trans Detail Total could not be blank',
            'transdetail.itemTotal.numeric' => 'Trans Detail Total must be numeric',

            'transdetail.itemCode.required' => 'Trans Detail Material ID could not be blank',
            'transdetail.itemCode.string' => 'Trans Detail Material ID must be String',
            'transdetail.itemCode.regex' => 'Trans Detail Material ID must be Numeric',
        ];
    }*/

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
