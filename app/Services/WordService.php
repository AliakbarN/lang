<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserWord;

final class WordService
{
    protected array $words;
    protected int $userId;

    public function __construct(array $words, int $userId)
    {
        $this->words = $words;
        $this->userId = $userId;
    }

    public function save(string $lang = 'en') :UserWord
    {
        $updatedUserWord = $this->addWords($lang);

        return $updatedUserWord;
    }

    public function update(array $wordsId, string $lang = 'en') :bool
    {
        if (count($this->words) !== count($wordsId)) {
            return false;
        }

        $words = $this->getWords();

        for ($i = 0; $i < count($wordsId); $i++) { 
            $words[$lang][$wordsId[$i]] = $this->words[$i];
        }



        return true;
    }

    public function addWords(string $lang) :UserWord
    {
        $words = $this->getWords();
        $user = $words['user'];
        $userRuWords = $words['ru'];
        $userEngWords = $words['eng'];

        switch($lang)
        {
            case 'eng':
                $userEngWords = array_merge($userEngWords, $this->words);
                break;
            case 'ru':
                $userRuWords = array_merge($userRuWords, $this->words);
                break;
        }

        $userWord = new UserWord(['ru' => $userRuWords, 'eng' => $userEngWords]);

        $user->userWord()->save();

        return $userWord;
    }

    public function getWords() :array
    {
        $user = User::find($this->userId);

        return ['ru' => $user->userWord()->ru, 'eng' => $user->userWord()->eng, 'user' => $user];
    }

    public function saveWord($words) :void
    {
        $userWord = new UserWord(['ru' => $userRuWords, 'eng' => $userEngWords]);

        $user->userWord()->save();
    }
}