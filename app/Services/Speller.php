<?php

namespace App\Services;

use GuzzleHttp\Client;

class Speller
{
    public static string $Url = SPELLERAPI_BASE_URL;
    protected Client $gz;
    protected array $words;
    protected string $sLang;
    protected static array $uriAliases = [
        'check' => '/checkText?lang=%sLang%&options=514&text='
    ];

    public function __construct(array $words, Client $guzzleClient, string $sLang = 'en')
    {
        $this->words = $words;
        $this->gz = $guzzleClient;
        $this->sLang = $sLang;

        $this->setLang();
    }

    protected function setLang() :void
    {
        foreach (self::$uriAliases as $key => $alias)
        {
            self::$uriAliases[$key] = str_replace('%sLang%', $this->sLang, $alias);
        }
    }

    public function checkIsWords() :bool | array
    {
        $inCorrectWords = [];
        foreach ($this->words as $word) {
            if (!preg_match('^[a-zA-Z0-9_ ]*$', $word) === 1) {
                $inCorrectWords[] = $word;
            }
        }

        if (count($inCorrectWords) !== 0) {
            return $inCorrectWords;
        }

        return true;
    }

    protected function isOneWord() :bool
    {
        if (count($this->words) !== 0) {
            return false;
        }

        return true;
    }

    public function check() :array
    {
        $query = '';

        if ($this->isOneWord()) {
            $query = $this->words[0];
        } else {
            $query = join('+', $this->words);
        }

        $res = $this->gz->get(self::$uriAliases['check'] . $query)->getBody()->getContents();

        if (count(json_decode($res)) === 0) {
            return [];
        }

        $checkedWords = [];

        foreach (json_decode($res) as $item)
        {
            $checkedWords[$item['word']] = $item['s'];
        }

        return $checkedWords;
    }

}


