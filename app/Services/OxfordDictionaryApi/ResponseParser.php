<?php

namespace App\Services\OxfordDictionaryApi;

class ResponseParser
{
    protected array $response = [];

    public function __construct(array $response)
    {
        $this->response = $response;
    }

    public function getTranslations() :array
    {
        $res = [];

        foreach($this->response['results'][0]['lexicalEntries'] as $lexicalEntri)
        {
            $type = $lexicalEntri['lexicalCategory']['id'];
            $res[$type] = [];

            foreach($lexicalEntri['entries'] as $entri)
            {
                foreach($entri['senses'] as $sense)
                {
                    $res[$type]['notes'] = $sense['notes'];
                    
                }
            }
        }

        return $res;
    }
}