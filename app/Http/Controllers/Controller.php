<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Services\OxfordDictionaryApi\DictionaryApi;
use App\Services\WordService;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var DictionaryApi
     */
    protected DictionaryApi $dictionaryApi;

    protected WordService $wordService;

    protected array $defaultResponseHeaders = [
        'Content-Type' => 'application/json'
    ];

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->dictionaryApi = new DictionaryApi($request->get('words'), new Client(['base_uri' => DictionaryApi::$URL, 'headers' => DictionaryApi::$defaultApiHeaders]), $request->get('sLang'));
        $this->wordService = new WordService($this->dictionaryApi);
    }
}
