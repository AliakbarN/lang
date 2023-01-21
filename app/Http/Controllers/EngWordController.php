<?php

namespace App\Http\Controllers;

use App\Models\EngWord;
use App\Services\OxfordDictionaryApi\DictionaryApi;
use App\Services\OxfordDictionaryApi\ResponseParser;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EngWordController// extends Controller
{
    /**
     * @var DictionaryApi
     */
    protected DictionaryApi $dictionaryApi;

    protected array $defaultResponseHeaders = [
        'Content-Type' => 'application/json'
    ];

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->dictionaryApi = new DictionaryApi($request->get('words'), new Client(['base_uri' => DictionaryApi::$URL, 'headers' => DictionaryApi::$defaultApiHeaders]), new ResponseParser(), $request->get('sLang'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param EngWord $engWord
     * @return Response
     */
    public function destroy(EngWord $engWord) :Response
    {
        //
    }
}
