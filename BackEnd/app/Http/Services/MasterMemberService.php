<?php

namespace App\Http\Services;

use App\Helpers\UniqueCodeHelper;
use App\Http\Requests\StoreMasterMemberRequest;
use App\Http\Requests\UpdateMasterMemberRequest;
use App\Models\MasterMember;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Throwable;

class MasterMemberService
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $statusCode = 0;
        $message = "";


        $mMember = MasterMember::select("*")
            ->search($request->input('search'))
            ->get();

        if ($mMember->isEmpty()) {
            $statusCode = 404;
            $message = "Data not found!";
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        }

        $statusCode = 200;
        $message = "success";
        return response()->json(GeneratePayload([$statusCode, $message, $mMember], "MasterMemberResource"))->setStatusCode($statusCode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(StoreMasterMemberRequest $request)
    {
        $statusCode = 0;
        $message = "";
        try {
            $dataSaved = MasterMember::create([
                'kode' => UniqueCodeHelper::generateCustomerCode(),
                'nama' => $request->input('memberName'),
                'email' => $request->input('memberEmail'),
                'no_hp' => $request->input('memberPhone'),
                'tgllahir' => $request->input('memberBirthdate'),
                'alamat' => $request->input('memberAddress'),
                'kota' => $request->input('memberCity'),
                'jnskelamin' => $request->has('memberSex') ? $request->input('memberSex') : 'L',
                'xpassword' => $request->has('memberPassword') ? $request->input('memberPassword') : 'DEFAULTPWD',
                'provinsi' => $request->has('memberProvince') ? $request->input('memberProvince') : $request->input('memberCity'),
            ]);
        } catch (Throwable $err) {
            dd($err);
            $statusCode = 404;
            $message = $err;
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        }

        $statusCode = 200;
        $message = "Data Saved!";
        return response()->json(GeneratePayload([$statusCode, $message, [$dataSaved]], "MasterMemberResource"))->setStatusCode($statusCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $statusCode = 0;
        $message = "";

        try {
            $mMember = MasterMember::findOrFail($id);
            $statusCode = 200;
            $message = "success";

            return response()->json(GeneratePayload([$statusCode, $message, [$mMember]], "MasterMemberResource"))->setStatusCode($statusCode);
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
    public function update(UpdateMasterMemberRequest $request, string $id)
    {
        $statusCode = 0;
        $message = "";


        try {
            $mMember = MasterMember::findOrFail($id);

            $mMember->update([
                "nama"  => $request->has('memberName') ? $request->input('memberName') : $mMember->nama,
                "email"  => $request->has('memberEmail') ? $request->input('memberEmail') : $mMember->email,
                "no_hp"  => $request->has('memberPhone') ? $request->input('memberPhone') : $mMember->no_hp,
                "tgllahir"  => $request->has('memberBirthdate') ? $request->input('memberBirthdate') : $mMember->tgllahir,
                "jnskelamin"  => $request->has('memberSex') ? $request->input('memberSex') : $mMember->jnskelamin,
                "xpassword"  => $request->has('memberPassword') ? $request->input('memberPassword') : $mMember->xpassword,
                "alamat"  => $request->has('memberAddress') ? $request->input('memberAddress') : $mMember->alamat,
                "kota"  => $request->has('memberCity') ? $request->input('memberCity') : $mMember->kota,
                "provinsi"  => $request->has('memberProvince') ? $request->input('memberProvince') : $mMember->provinsi,
            ]);

            $statusCode = 200;
            $message = "Data Updated!";
            return response()->json(GeneratePayload([$statusCode, $message, [$mMember]], "MasterMemberResource"))->setStatusCode($statusCode);
        } catch (ModelNotFoundException $err) {
            $statusCode = 404;
            $message = "Master Member not found!";
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        } catch (Throwable $err) {
            $statusCode = 404;
            $message = $err;
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
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
            $mMember = MasterMember::findOrFail($id);
            $mMember->delete();
            $statusCode = 200;
            $message = "Data Deleted!";
            return response()->json(GeneratePayload([$statusCode, $message, [$mMember]], "MasterMemberResource"))->setStatusCode($statusCode);
        } catch (ModelNotFoundException $err) {
            $statusCode = 404;
            $message = "Master Member not found!";
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        } catch (Throwable $th) {
            $statusCode = 404;
            $message = $th->getMessage();
            return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
        }
    }
}
