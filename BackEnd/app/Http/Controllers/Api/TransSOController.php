<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransSORequest;
use App\Http\Requests\UpdateTransSORequest;
use App\Http\Services\TransSOService;
use Illuminate\Http\Request;

class TransSOController extends Controller
{
    public function __construct(
        private TransSOService $transSOService
    ) {
        $this->transSOService = $transSOService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->transSOService->index($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(StoreTransSORequest $request)
    {

        return $this->transSOService->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->transSOService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateTransSORequest $request, string $id)
    {
        return $this->transSOService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        return $this->transSOService->destroy($id);
    }
}
