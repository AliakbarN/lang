<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\Speller;
use Illuminate\Http\Response;

class EnsureWordIsCorrect
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response|RedirectResponse) $next
     * @return RedirectResponse
     */
    public function handle(Request $request, Closure $next) :RedirectResponse
    {
        $response = $next();
        $speller = new Speller((array)$request->get('word'), new Client(['base_uri' => Speller::$Url]), (string)$request->get(['lang']));

        if (!$speller->checkIsWords()) {
            return $response->setStatusCode(406)->send();
        }

        $availableOptions = $speller->check();

        if (count($availableOptions) > 0) {
            $response->setContent(new Response(json_encode(['availableOptions' => $availableOptions])));
            $response->setStatusCode(406, 'Words are incorrect')->send();
        }

        $response->setRequest($request);
        return $next($response);
    }
}
