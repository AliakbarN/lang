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

    protected static array $uriAliases = [
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

        // $this->setLang();
    }

    protected function parseWords(string $words) :array
    {
        return explode(' ', $words);
    }

    protected function setLang(string|null $aliasKey = null) :void
    {
        if ($aliasKey !== null) {
            self::$uriAliases[$aliasKey] = str_replace('%sLang%', $this->sLang, self::$uriAliases[$aliasKey]);

            if (str_contains($aliasKey, '%tLang%')) {
                if ($this->sLang === 'en') {
                    self::$uriAliases[$aliasKey] = str_replace('%tLang%', 'ru', self::$uriAliases[$aliasKey]);
                } else {
                    self::$uriAliases[$aliasKey] = str_replace('%tLang%', 'en', self::$uriAliases[$aliasKey]);
                }
            }
        } else {
            foreach (self::$uriAliases as $key => $alias)
            {
                self::$uriAliases[$key] = str_replace('%sLang%', replace: $this->sLang, subject: $alias);

                if (str_contains($alias, '%tLang%')) {
                    if ($this->sLang === 'en') {
                        self::$uriAliases[$key] = str_replace('%tLang%', 'ru', $alias);
                    } else {
                        self::$uriAliases[$key] = str_replace('%tLang%', 'en', $alias);
                    }
                }
            }
        }
    }

    public function getTranslation(string $sLang = 'en') : array
    {
        $res = [];

//        if ($sLang !== 'en') {
//            $this->sLang = $sLang;
//            $this->setLang('trns');
//        }

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

//        if ($sLang !== 'en') {
//            $this->sLang = $sLang;
//            $this->setLang('syn');
//        }

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
}
