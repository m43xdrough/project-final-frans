<?php

namespace App\Http\Services;

use App\Helpers\UniqueCodeHelper;
use App\Http\Requests\StoreTransSORequest;
use App\Http\Requests\UpdateTransSORequest;
use App\Models\TransSOD;
use App\Models\TransSOH;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class TransSOService
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $statusCode = 0;
        $message = "";
        //$tSOH = TransSOH::all();

        $tSOH = TransSOH::select("*")
            ->search($request->input('search'))
            ->get();

        if ($tSOH->isEmpty()) {
            $statusCode = 404;
            $message = "Data not found!";
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        }

        $statusCode = 200;
        $message = "";
        return response()->json(GeneratePayload([$statusCode, $message, $tSOH], "TransSOHResource"))->setStatusCode($statusCode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(StoreTransSORequest $request)
    {
        $statusCode = 0;
        $message = "";


        try {
            DB::beginTransaction();
            $notrans = UniqueCodeHelper::generateSalesOrderCode();
            $dataSaved = TransSOH::create([
                'notrans' => $notrans,
                'tgltrans' => now(),
                'subtotal' => $request->input('soSubtotal'),
                'totdisc' => $request->input('soTotalDisc'),
                'totppn' => $request->input('soTotalPPN'),
                'grandtotal' => $request->input('soGrandTotal'),
                'resep_id' => $request->input('soReceipt_Id'),
            ]);
            //$dataSaved = TransSOH::select('id')->where('notrans', '=', $notrans)->limit(1)->get();


            //dd($dataSaved->id);

            $dataDtl = $request->input('transdetail');
            for ($i = 0; $i < count($dataDtl); $i++) {

                $dataSavedDtl = TransSOD::create([
                    'tsoh_id' => $dataSaved->id,
                    'nourut' => $dataDtl[$i]['itemNo'],
                    'material_id' => $dataDtl[$i]['itemID'],
                    'qty' => $dataDtl[$i]['itemQty'],
                    'harga' => $dataDtl[$i]['itemPrice'],
                    'disc' => $dataDtl[$i]['itemDisc'],
                    'ndisc' => $dataDtl[$i]['itemNDisc'],
                    'ppn' => $dataDtl[$i]['itemPPN'],
                    'nppn' => $dataDtl[$i]['itemNPPN'],
                    'total' => $dataDtl[$i]['itemTotal'],
                ]);
            }
            DB::commit();
            $statusCode = 200;
            $message = "Data Saved!";
            return response()->json(GeneratePayload([$statusCode, $message, [$dataSaved]], "TransSOHResource"))->setStatusCode($statusCode);
        } catch (ModelNotFoundException $err) {
            DB::rollBack();
            $statusCode = 404;
            $message = "Trans SO not found!";
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        } catch (Exception $err) {
            DB::rollBack();
            $statusCode = 404;
            $message = $err;
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $statusCode = 0;
        $message = "";

        try {
            $tSOH = TransSOH::findOrFail($id);
            $statusCode = 200;
            $message = "success";

            return response()->json(GeneratePayload([$statusCode, $message, [$tSOH]], "TransSOHResource"))->setStatusCode($statusCode);
        } catch (ModelNotFoundException $err) {
            $statusCode = 404;
            $message = "Transaksi SO not found!";
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        } catch (Throwable $th) {
            $statusCode = 404;
            $message = $th;
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateTransSORequest $request, string $id)
    {
        $statusCode = 0;
        $message = "";


        try {
            DB::beginTransaction();
            $tSOH = TransSOH::findOrFail($id);
            $tSOH->update([
                "subtotal"  => $request->has('soSubtotal') ? $request->input('soSubtotal') : $tSOH->subtotal,
                "totdisc"  => $request->has('soTotalDisc') ? $request->input('soTotalDisc') : $tSOH->totdisc,
                "totppn"  => $request->has('soTotalPPN') ? $request->input('soTotalPPN') : $tSOH->totppn,
                "grandtotal"  => $request->has('soGrandTotal') ? $request->input('soGrandTotal') : $tSOH->grandtotal,
            ]);

            TransSOD::where('tsoh_id', '=', $tSOH->id)->delete();

            $dataDtl = $request->input('transdetail');
            for ($i = 0; $i < count($dataDtl); $i++) {
                TransSOD::create([
                    'tsoh_id' => $tSOH->id,
                    'nourut' => $dataDtl[$i]['itemNo'],
                    'material_id' => $dataDtl[$i]['itemID'],
                    'qty' => $dataDtl[$i]['itemQty'],
                    'harga' => $dataDtl[$i]['itemPrice'],
                    'disc' => $dataDtl[$i]['itemDisc'],
                    'ndisc' => $dataDtl[$i]['itemNDisc'],
                    'ppn' => $dataDtl[$i]['itemPPN'],
                    'nppn' => $dataDtl[$i]['itemNPPN'],
                    'total' => $dataDtl[$i]['itemTotal'],
                ]);
            }


            $statusCode = 200;
            $message = "Data Updated!";

            DB::commit();

            return response()->json(GeneratePayload([$statusCode, $message, [$tSOH]], "TransSOHResource"))->setStatusCode($statusCode);
        } catch (ModelNotFoundException $err) {
            DB::rollBack();
            $statusCode = 404;
            $message = "Master Material not found!";
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        } catch (\Throwable $err) {
            DB::rollBack();
            $statusCode = 404;
            return response()->json(GeneratePayload([$statusCode, $err]))->setStatusCode($statusCode);
        }


        $tSOH = TransSOH::find($id);
        if (is_null($tSOH)) {
            $statusCode = 404;
            $message = "Data not found!";
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        }

        try {
            $tSOH->subtotal = $request->has('subtotal') ? $request->input('subtotal') : $tSOH->subtotal;
            $tSOH->totdisc = $request->has('totdisc') ? $request->input('totdisc') : $tSOH->totdisc;
            $tSOH->totppn = $request->has('totppn') ? $request->input('totppn') : $tSOH->totppn;
            $tSOH->grandtotal = $request->has('grandtotal') ? $request->input('grandtotal') : $tSOH->grandtotal;
            $tSOH->save();
        } catch (Throwable $err) {
            $statusCode = 404;
            $message = $err;
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        }

        $statusCode = 200;
        $message = "Data Updated!";
        return response()->json(GeneratePayload([$statusCode, $message, $tSOH], "TransSOHResource"))->setStatusCode($statusCode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $statusCode = 0;
        $message = "";

        try {
            $tSOH = TransSOH::findOrFail($id);
            $tSOH->delete();
            $statusCode = 200;
            $message = "Data Deleted!";
            return response()->json(GeneratePayload([$statusCode, $message, [$tSOH]], "TransSOHResource"))->setStatusCode($statusCode);
        } catch (ModelNotFoundException $err) {
            $statusCode = 404;
            $message = "Transaksi SO not found!";
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        } catch (Throwable $th) {
            $statusCode = 404;
            $message = $th->getMessage();
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        }
    }
}
