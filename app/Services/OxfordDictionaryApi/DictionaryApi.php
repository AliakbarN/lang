<?php

namespace App\Services\OxfordDictionaryApi;

use GuzzleHttp\Client as Guzzle;

final class DictionaryApi
{
    protected static string $URL = OXFORDAPI_BASE_URL;

    protected static array $uriAliases = [
        'trns' => '/translations/en/ru/',
        'syn' => '/thesaurus/en/'
    ];

    public static function getTranslation(array $words, string $tLang = 'ru') :array
    {
        $gz = new Guzzle(['base_uri' => self::$URL]);
        $res = [];

        if ($tLang !== 'ru') {
            self::$uriAliases['trns'] = strtr(self::$uriAliases['trns'], ['en' => 'ru', 'ru' => 'en']);
        }

        foreach($words as $word)
        {
            $res[] = $gz->get(self::$uriAliases['trns'] . $word, [
                'headers' => [
                    'app_key' => env('OXFORDAPI_KEY'),
                    'app_id' => env('OXFORDAPI_ID')
                ]
            ]);
        }

        return $res;
    }

    public static function getSynonyms(array $words, string $lang = 'en') :array
    {
        $gz = new Guzzle(['base_uri' => self::$URL]);
        $res = [];

        if ($lang !== 'en') {
            self::$uriAliases['syn'] = str_replace('en', 'ru', self::$uriAliases['syn']);
        }

        foreach($words as $word)
        {
            $res[] = $gz->get(self::$uriAliases['syn'] . $word, [
                'headers' => [
                    'app_key' => env('OXFORDAPI_KEY'),
                    'app_id' => env('OXFORDAPI_ID')
                ]
            ]);
        }

        return $res;
    }
}