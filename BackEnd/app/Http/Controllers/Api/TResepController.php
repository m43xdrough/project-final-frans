<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTResepRequest;
use App\Http\Requests\UpdateTResepRequest;
use App\Http\Services\TransResepService;
use App\Models\MasterMember;
use App\Models\TransResep;
use Exception;
use Illuminate\Http\Request;

class TResepController extends Controller
{
    public function __construct(
        private TransResepService $transResepService
    ) {
        $this->transResepService = $transResepService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->transResepService->index($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(StoreTResepRequest $request)
    {
        return $this->transResepService->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->transResepService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateTResepRequest $request, string $id)
    {
        return $this->transResepService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        return $this->transResepService->destroy($id);
    }
}
