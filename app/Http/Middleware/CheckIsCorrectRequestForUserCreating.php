<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckIsCorrectRequestForUserCreating
{
    protected string $errorMessage = 'The request is incorrect. It lacks';

    protected array $needyOptions = [
        'name',
        'email',
        'password'
    ];

    protected bool $isIncorrect = false;

    protected array $data = [];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        foreach($this->needyOptions as $option)
        {
            $optionData = $request->get($option);

            if ($optionData === null) {
                $this->isIncorrect = true;
                $this->errorMessage += ' ' . $option;
            } else {
                $this->data[$option] = $optionData;
            }
        }

        if ($this->isIncorrect) {
            return new Response($this->errorMessage, 407);
        }

        $request['parsedData'] = $this->data;
        
        return $next($request);
    }
}
