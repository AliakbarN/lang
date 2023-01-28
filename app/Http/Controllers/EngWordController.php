<?php

namespace App\Http\Controllers;

use App\Models\EngWord;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EngWordController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() :Response
    {
        $words = EngWord::all();
        return new Response($words->all(), 200, $this->defaultResponseHeaders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) :Response
    {
        $sLang = $request->get('lang');

        $translations = $this->dictionaryApi->getTranslation($sLang);
        $synonyms = $this->dictionaryApi->getSynonyms($sLang);

        return new Response('Ok', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param EngWord $engWord
     * @return Response
     */
    public function show(EngWord $engWord) :Response
    {
        return new Response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param EngWord $engWord
     * @return Response
     */
    public function update(Request $request, EngWord $engWord) :Response
    {
        return new Response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param EngWord $engWord
     * @return Response
     */
    public function destroy(EngWord $engWord) :Response
    {
        return new Response();
    }
}
