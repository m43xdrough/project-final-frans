<?php

namespace App\Http\Services;

use App\Helpers\UniqueCodeHelper;
use App\Http\Requests\StoreTResepRequest;
use App\Http\Requests\UpdateTResepRequest;
use App\Http\Resources\MasterMemberResource;
use App\Models\TransResep;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Throwable;

class TransResepService
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $statusCode = 0;
        $message = "";
        //$tResep = TransResep::all();
        $tResep = TransResep::select("*")
            ->search($request->input('search'))
            ->get();

        if ($tResep->isEmpty()) {
            $statusCode = 404;
            $message = "Data not found!";
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        }

        $statusCode = 200;
        $message = "success";
        return response()->json(GeneratePayload([$statusCode, $message, $tResep], "TransResepResource"))->setStatusCode($statusCode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(StoreTResepRequest $request)
    {
        $statusCode = 0;
        $message = "";

        try {
            $dataSaved = TransResep::create([
                'noresep' => UniqueCodeHelper::generateCustomerCode(),
                'tglresep' => now(),
                'chspherisr' => $request->input('receiptSpherisr'),
                'chspherisl' => $request->input('receiptSpherisl'),
                'chcylinderr' => $request->input('receiptCylinderr'),
                'chcylinderl' => $request->input('receiptCylinderl'),
                'chadditionr' => $request->input('receiptAdditionr'),
                'chadditionl' => $request->input('receiptAdditionl'),
                'chaxisr' => $request->input('receiptAxisr'),
                'chaxisl' => $request->input('receiptAxisl'),
                'member_id' => $request->input('receiptMemberID'),
            ]);
        } catch (Throwable $err) {
            $statusCode = 404;
            $message = $err;
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        }

        $statusCode = 200;
        $message = "Data Saved!";
        return response()->json(GeneratePayload([$statusCode, $message, [$dataSaved]], "TransResepResource"))->setStatusCode($statusCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $statusCode = 0;
        $message = "";

        try {
            $tResep = TransResep::findOrFail($id);
            $statusCode = 200;
            $message = "success";

            return response()->json(GeneratePayload([$statusCode, $message, [$tResep]], "TransResepResource"))->setStatusCode($statusCode);
        } catch (ModelNotFoundException $err) {
            $statusCode = 404;
            $message = "Trans Resep not found!";
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
    public function update(UpdateTResepRequest $request, string $id)
    {
        $statusCode = 0;
        $message = "";

        try {
            $tResep = TransResep::findOrFail($id);
            $tResep->update([
                "chspherisr"  => $request->has('receiptSpherisr') ? $request->input('receiptSpherisr') : $tResep->chspherisr,
                "chspherisl"  => $request->has('receiptSpherisl') ? $request->input('receiptSpherisl') : $tResep->chspherisl,
                "chcylinderr"  => $request->has('receiptCylinderr') ? $request->input('receiptCylinderr') : $tResep->chcylinderr,
                "chcylinderl"  => $request->has('receiptCylinderl') ? $request->input('receiptCylinderl') : $tResep->chcylinderl,
                "chadditionr"  => $request->has('receiptAdditionr') ? $request->input('receiptAdditionr') : $tResep->chadditionr,
                "chadditionl"  => $request->has('receiptAdditionl') ? $request->input('receiptAdditionl') : $tResep->chadditionl,
                "chaxisr"  => $request->has('receiptAxisr') ? $request->input('receiptAxisr') : $tResep->chaxisr,
                "chaxisl"  => $request->has('receiptAxisr') ? $request->input('receiptAxisr') : $tResep->chaxisl,
            ]);
            $statusCode = 200;
            $message = "Data Updated!";
            return response()->json(GeneratePayload([$statusCode, $message, [$tResep]], "TransResepResource"))->setStatusCode($statusCode);
        } catch (ModelNotFoundException $err) {
            $statusCode = 404;
            $message = "Trans Resep not found!";
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        } catch (\Throwable $err) {
            $statusCode = 404;
            return response()->json(GeneratePayload([$statusCode, $err]))->setStatusCode($statusCode);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $statusCode = 0;
        $message = "";

        try {
            $mMember = TransResep::findOrFail($id);
            $mMember->delete();
            $statusCode = 200;
            $message = "Data Deleted!";
            return response()->json(GeneratePayload([$statusCode, $message, [$mMember]], "TransResepResource"))->setStatusCode($statusCode);
        } catch (ModelNotFoundException $err) {
            $statusCode = 404;
            $message = "Trans Resep not found!";
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        } catch (Throwable $th) {
            $statusCode = 404;
            $message = $th->getMessage();
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        }
    }
}
