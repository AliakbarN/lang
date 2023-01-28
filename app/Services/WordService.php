<?php

namespace App\Services;

use App\Models\EngWord;
use App\Models\RuWord;
use App\Services\OxfordDictionaryApi\DictionaryApi;

final class WordService
{
    protected DictionaryApi $dictionaryApi;
    protected EngWord|RuWord $model;

    public function __construct(DictionaryApi $dictionaryApi)
    {
        $this->dictionaryApi = $dictionaryApi;
    }

    public function setModel(RuWord|EngWord $model) :void
    {
        $this->model = $model;
    }

    public function save() :void
    {
        
    }
}