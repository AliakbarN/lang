<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\OxfordDictionaryApi\DictionaryApi;
use App\Services\WordService;
use GuzzleHttp\Client;

final class WordController extends Controller
{
    protected string $lang;

    /**
     * @var DictionaryApi
     */
    protected DictionaryApi $dictionaryApi;

    protected WordService $wordService;

    public function __construct(Request $request)
    {
        $this->lang = $request->get('lang');
        $this->dictionaryApi = new DictionaryApi($request->get('words'), new Client(['base_uri' => DictionaryApi::$URL, 'headers' => DictionaryApi::$defaultApiHeaders]), $this->lang);
        $this->wordService = new WordService($request->get('words'), $request->get('userId'));
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
        $userWord = $this->wordService->save($this->lang);

        return new Response($userWord, headers: $this->defaultResponseHeaders);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
