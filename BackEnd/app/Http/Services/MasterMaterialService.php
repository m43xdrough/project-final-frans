<?php

namespace App\Http\Services;

use App\Helpers\UniqueCodeHelper;
use App\Http\Requests\StoreMasterMaterialRequest;
use App\Http\Requests\UpdateMasterMaterialRequest;
use App\Http\Resources\MasterMaterialResource;
use App\Models\MasterMaterial;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Throwable;

class MasterMaterialService
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $statusCode = 0;
        $message = "";

        $mMaterial = MasterMaterial::select("*")
            ->search($request->input('search'))
            ->get();

        if ($mMaterial->isEmpty()) {
            $statusCode = 404;
            $message = "Data not found!";
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        }

        $statusCode = 200;
        $message = "success";

        return response()->json(GeneratePayload([$statusCode, $message, $mMaterial], "MasterMaterialResource"))->setStatusCode($statusCode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(StoreMasterMaterialRequest $request)
    {
        $statusCode = 0;
        $message = "";

        /*$mMaterial = MasterMaterial::where('kdbarang', '=', $request->input('materialCode'))->withTrashed()->get();
        if (!$mMaterial->isEmpty()) {
            $statusCode = 400;
            $message = "Data already exist!";
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        }*/

        try {
            $dataSaved = MasterMaterial::create([
                'kdbarang' => UniqueCodeHelper::generateMaterialCode(), //$request->input('materialCode'),
                'namabarang' => $request->input('materialDescription'),
                'harga' => $request->input('materialPrice'),
            ]);
        } catch (Exception $err) {
            dd($err);
            $statusCode = 404;
            return response()->json(GeneratePayload([$statusCode, $err]))->setStatusCode($statusCode);
        }

        $statusCode = 200;
        $message = "Data Saved!";
        return response()->json(GeneratePayload([$statusCode, $message, [$dataSaved]], "MasterMaterialResource"))->setStatusCode($statusCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $statusCode = 0;
        $message = "";
        /*if (!is_numeric($id)) {
            $statusCode = 400;
            $message = "ID must be number!";
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        }*/

        //$mMaterial = MasterMaterial::where('id', '=', $id)->get();                  //soft delete diexclude
        //$mMember = MasterMaterial::where('id', '=', $id)->withTrashed()->get(); //ambil semua data (termasuk yang telah dihapus)
        //$mMember = MasterMaterial::where('id', '=', $id)->onlyTrashed()->get(); //ambil data hanya yang telah dihapus
        try {
            $mMaterial = MasterMaterial::findOrFail($id);
            $statusCode = 200;
            $message = "success";

            return response()->json(GeneratePayload([$statusCode, $message, [$mMaterial]], "MasterMaterialResource"))->setStatusCode($statusCode);
        } catch (ModelNotFoundException $err) {
            $statusCode = 404;
            $message = "Master Material not found!";
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
    public function update(UpdateMasterMaterialRequest $request, string $id)
    {
        $statusCode = 0;
        $message = "";

        /*$mMaterial = MasterMaterial::find($id);
        if (is_null($mMaterial)) {
            $statusCode = 404;
            $message = "Data not found!";
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        }*/

        try {
            $mMaterial = MasterMaterial::findOrFail($id);
            $mMaterial->update([
                "namabarang"  => $request->has('materialDescription') ? $request->input('materialDescription') : $mMaterial->namabarang,
                "harga"  => $request->has('materialPrice') ? $request->input('materialPrice') : $mMaterial->harga,
            ]);
            /*$mMaterial->namabarang = $request->has('materialDescription') ? $request->input('materialDescription') : $mMaterial->namabarang;
            $mMaterial->harga = $request->has('materialPrice') ? $request->input('materialPrice') : $mMaterial->harga;
            $mMaterial->save();*/

            $statusCode = 200;
            $message = "Data Updated!";
            return response()->json(GeneratePayload([$statusCode, $message, [$mMaterial]], "MasterMaterialResource"))->setStatusCode($statusCode);
        } catch (ModelNotFoundException $err) {
            $statusCode = 404;
            $message = "Master Material not found!";
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        } catch (\Throwable $err) {
            $statusCode = 404;
            return response()->json(GeneratePayload([$statusCode, $err]))->setStatusCode($statusCode);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $statusCode = 0;
        $message = "";

        try {
            $mMaterial = MasterMaterial::findOrFail($id);
            $mMaterial->delete();
            $statusCode = 200;
            $message = "Data Deleted!";
            return response()->json(GeneratePayload([$statusCode, $message, [$mMaterial]], "MasterMaterialResource"))->setStatusCode($statusCode);
        } catch (ModelNotFoundException $err) {
            $statusCode = 404;
            $message = "Master Material not found!";
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        } catch (Throwable $th) {
            $statusCode = 404;
            $message = $th->getMessage();
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        }

        /*if (!is_numeric($id)) {
            $statusCode = 400;
            $message = "ID must be number!";
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        }

        $mMaterial = MasterMaterial::find($id);
        if (is_null($mMaterial)) {
            $statusCode = 404;
            $message = "Data not found!";
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        }

        try {
            $mMaterial->delete();
        } catch (\Throwable $err) {
            $statusCode = 404;
            return response()->json(GeneratePayload([$statusCode, $err]))->setStatusCode($statusCode);
        }

        $statusCode = 200;
        $message = "Data Deleted!";
        return response()->json(GeneratePayload([$statusCode, $message, $mMaterial], "MasterMaterialResource"))->setStatusCode($statusCode);*/
    }
}
