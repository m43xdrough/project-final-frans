<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests\UserRequest;
use App\Http\Services\UserService;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    )
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
    */
    public function index(Request $request)
    {
        return $this->userService->index($request);
    }

    /**
     * Store a newly created resource in storage.
    */
    public function store(UserRequest $request)
    {
        return $this->userService->store($request);
    }

    /**
     * Display the specified resource.
    */
    public function show(string $id)
    {
        return $this->userService->show($id);
    }

    /**
     * Update the specified resource in storage.
    */
    public function update(UserRequest $request, string $id)
    {
        return $this->userService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
    */
    public function destroy(string $id)
    {
        return $this->userService->destroy($id);
    }
}
