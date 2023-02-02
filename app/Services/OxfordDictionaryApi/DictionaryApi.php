<?php

namespace App\Services\OxfordDictionaryApi;

use GuzzleHttp\Client;
use App\Services\OxfordDictionaryApi\ResponseParser;

final class DictionaryApi
{
    /**
     * @var string
     */
    public static string $URL = 'https://od-api.oxforddictionaries.com/api/v2/';//OXFORDAPI_BASE_URL;
    /**
     * @var array
     */
    public array $words;
    /**
     * @var string
     */
    protected string $sLang;
    /**
     * @var Client
     */
    protected Client $gz;
    /**
     * @var ResponseParser
     */
    protected ResponseParser $parser;

    protected array $uriAliases = [
        'trns' => 'translations/en/ru/',
        'syn' => 'thesaurus/en/',
        'ent' => 'entries/%sLang%/'
    ];

    public static array $defaultApiHeaders = [
        'app_key' => OXFORDAPI_KEY,
        'app_id' => OXFORDAPI_ID
    ];

    public function __construct(string $words, Client $gz, string $sLang = 'en')
    {
        $this->sLang = $sLang;
        $this->words = $this->parseWords($words);
        $this->gz = $gz;
        $this->parser = new ResponseParser();

        $this->setLang();
    }

    protected function parseWords(string $words) :array
    {
        return explode(' ', $words);
    }

    protected function setLang(string $aliasKey = null) :void
    {
        if ($aliasKey !== null) {
            $this->uriAliases[$aliasKey] = str_replace('%sLang%', $this->sLang, $this->uriAliases[$aliasKey]);

            if (str_contains($this->uriAliases[$aliasKey], '%tLang%')) {
                if ($this->sLang === 'ru') {
                    $this->uriAliases[$aliasKey] = str_replace('%tLang%', 'en', $this->uriAliases[$aliasKey]);
                } else if ($this->sLang === 'en') {
                    $this->uriAliases[$aliasKey] = str_replace('%sLang%', 'ru', $this->uriAliases[$aliasKey]);
                }
            }
        } else {
            foreach($this->uriAliases as $key => $aliase)
            {
                $this->uriAliases[$key] = str_replace('%sLang%', $this->sLang, $aliase);

                if (str_contains($this->uriAliases[$aliase], '%tLang%')) {
                    if ($this->sLang === 'ru') {
                        $this->uriAliases[$key] = str_replace('%tLang%', 'en', $aliase);
                    } else if ($this->sLang === 'en') {
                        $this->uriAliases[$key] = str_replace('%sLang%', 'ru', $aliase);
                    }
                }
            }
        }
    }

    public function getTranslation(string $sLang = 'en') : array
    {
        $res = [];

       if ($sLang !== 'en') {
           $this->sLang = $sLang;
           $this->setLang('trns');
       }

        foreach($this->words as $word)
        {
            $res[] = $this->gz->get(self::$uriAliases['trns'] . $word);
        }

        $parsedRes = [];

        foreach ($res as $response)
        {
            $this->parser->setResponse(json_decode($response->getBody()->getContents(), true));
            $parsedRes[] = $this->parser->getTranslations();
        }

        return $parsedRes;
    }

    public function getSynonyms(string $sLang = 'en') :array
    {
        $res = [];

       if ($sLang !== 'en') {
           $this->sLang = $sLang;
           $this->setLang('syn');
       }

        foreach($this->words as $word)
        {
            $res[] = $this->gz->get(self::$uriAliases['syn'] . $word);
        }

        $parsedRes = [];

        foreach ($res as $response)
        {
            $this->parser->setResponse(json_decode($response->getBody()->getContents(), true));
            $parsedRes[] = $this->parser->getSynonyms();
        }

        return $parsedRes;
    }

    public function getEntries(string $sLang = 'en') :array
    {
        return [];
    }
}
