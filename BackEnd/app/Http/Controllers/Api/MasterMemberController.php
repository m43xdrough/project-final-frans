<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasterMemberRequest;
use App\Http\Requests\UpdateMasterMemberRequest;
use App\Http\Services\MasterMemberService;
use Illuminate\Http\Request;

class MasterMemberController extends Controller
{

    public function __construct(
        private MasterMemberService $masterMemberService
    ) {
        $this->masterMemberService = $masterMemberService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->masterMemberService->index($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(StoreMasterMemberRequest $request)
    {
        return $this->masterMemberService->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->masterMemberService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateMasterMemberRequest $request, string $id)
    {
        return $this->masterMemberService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        return $this->masterMemberService->destroy($id);
    }
}
