<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasterMaterialRequest;
use App\Http\Requests\UpdateMasterMaterialRequest;
use App\Http\Services\MasterMaterialService;
use Illuminate\Http\Request;


class MasterMaterialController extends Controller
{
    public function __construct(
        private MasterMaterialService $masterMaterialService
    ) {
        $this->masterMaterialService = $masterMaterialService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->masterMaterialService->index($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(StoreMasterMaterialRequest $request)
    {
        return $this->masterMaterialService->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->masterMaterialService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateMasterMaterialRequest $request, string $id)
    {
        return $this->masterMaterialService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        return $this->masterMaterialService->destroy($id);
    }
}
