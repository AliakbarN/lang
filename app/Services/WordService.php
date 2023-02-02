<?php

namespace App\Services;

use App\Models\EngWord;
use App\Models\RuWord;

final class WordService
{
    protected EngWord|RuWord $model;
    protected array $words;

    public function __construct(array $words)
    {
        $this->words = $words;
    }

    public function setModel(RuWord|EngWord $model) :void
    {
        $this->model = $model;
    }

    public function save(string $word = null, array $translations = null, array $synonyms = null) :void
    {
         
    }

    public function saveOneWord(string $word, array $translation) :void
    {

    }
}