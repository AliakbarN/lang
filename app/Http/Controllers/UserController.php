<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new Response($this->userService->all()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $isUserSaved = $this->userService->save();

        if (!$isUserSaved) {
            return new Response('Something went wrong', 505);
        }

        return new Response('The user has been created successufilly');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userService->getById();

        if (!$user) {
            return new Response('Something went wrong', 505);
        }

        return new Response($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $isUserUpdated = $this->userService->update();

        if (!$isUserUpdated) {
            return new Response('Something went wrong', 505);
        }

        return new Response('The user has been updated successufilly');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isUserDeleted = $this->userService->delete();

        if (!$isUserDeleted) {
            return new Response('Something went wrong', 505);
        }

        return new Response('The user has been deleted successufilly');
    }
}
