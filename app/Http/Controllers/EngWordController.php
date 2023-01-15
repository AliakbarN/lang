<?php

namespace App\Http\Controllers;

use App\Models\EngWord;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class EngWordController// extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() :Response
    {
        $words = EngWord::all();
        return new Response(200, [], json_encode($words));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) :Response
    {
        return new Response();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EngWord  $engWord
     * @return \Illuminate\Http\Response
     */
    public function show(EngWord $engWord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EngWord  $engWord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EngWord $engWord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EngWord  $engWord
     * @return \Illuminate\Http\Response
     */
    public function destroy(EngWord $engWord)
    {
        //
    }
}
