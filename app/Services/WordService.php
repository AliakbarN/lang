<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserWord;
use Exception;

final class WordService
{
    protected array $words;

    public function __construct(array $words)
    {
        $this->words = $words;
    }
    
    public function save(string $lang = 'en') :UserWord
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

        $isWordSaved = $user->userWord()->save($userWord);

        if (!$isWordSaved) {
            throw new Exception('Something went wrong (given word was not saved)', 505);
        }

        return $userWord;
    }

    public function update(array $wordsId, string $lang = 'en') :void
    {
        if (count($this->words) !== count($wordsId)) {
            throw new Exception("The given data is inncorect - the array's (new words for updating) length is not matched with array's (ids of former elements) length ", 400);
        }

        $words = $this->getWords();

        for ($i = 0; $i < count($wordsId); $i++) { 
            $words[$lang][$wordsId[$i]] = $this->words[$i];
        }

        $isUpdated = $words['user']->userWord()->update([$lang => $words[$lang]]);

        if (!$isUpdated) {
            throw new Exception('Something went wrong (given words were not updated)', 505);
        }
    }

    public function getWordById(int $id, int $userWordId, string $lang = 'en') :string
    {
        $userWord = UserWord::find($id);

        if ($userWord === null) {
            throw new Exception("The user's word with id = $id not found", 505);
        }

        return $userWord[$lang][$userWordId];
    }

    public function all() :array
    {
        return (UserWord::all())->toArray();
    }

    public function removeWord(int $id, int $userWordId, string $lang = 'en') :void
    {

    }
}