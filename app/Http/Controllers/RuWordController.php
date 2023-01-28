<?php

namespace App\Http\Controllers;

use App\Models\RuWord;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RuWordController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RuWord  $ruWord
     * @return \Illuminate\Http\Response
     */
    public function show(RuWord $ruWord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RuWord  $ruWord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RuWord $ruWord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RuWord  $ruWord
     * @return \Illuminate\Http\Response
     */
    public function destroy(RuWord $ruWord)
    {
        //
    }
}
