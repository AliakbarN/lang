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

    public function save(string $lang) :UserWord
    {
        $updatedUserWord = $this->addWords($lang);

        return $updatedUserWord;
    }

    public function addWords(string $lang) :UserWord
    {
        $user = User::find($this->userId);
        $userRuWords = $user->userWord()->ru;
        $userEngWords = $user->userWord()->eng;

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

        $user->userWord()->save($userWord);

        return $userWord;
    } 
}