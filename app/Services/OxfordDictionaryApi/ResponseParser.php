<?php

namespace App\Services\OxfordDictionaryApi;

class ResponseParser
{
    protected array $response = [];

    /**
     * @param array $response
     * @return void
     */
    public function setResponse(array $response) :void
    {
        $this->response = $response;
    }

    /**
     * @return array
     */
    public function getTranslations() :array
    {
        $res = [];

        foreach($this->response['results'][0]['lexicalEntries'] as $lexicalEntry)
        {
            $type = $lexicalEntry['lexicalCategory']['id'];
            $res[$type] = [];

            foreach($lexicalEntry['entries'] as $entry)
            {
                foreach($entry['senses'] as $sense)
                {
                    if (array_key_exists('notes', $sense)) {
                        if (!array_key_exists('notes', $res[$type])) {
                            $res[$type]['notes'] = [];
                        }
                        $note = [];
                        $note['text'] = $sense['notes'][0]['text'];

                        if (array_key_exists('translations', $sense)) {
                            $note['translation'] = [];

                            foreach ($sense['translations'] as $translation)
                            {
                                $note['translation'][] = $translation['text'];
                            }
                        }

                        if (array_key_exists('examples', $sense)) {
                             $note['examples'] = [];

                            foreach ($sense['examples'] as $example)
                            {
                                $note['examples'][] = [$example['text'] => $example['translations'][0]['text']];
                            }
                        }

                        $res[$type]['notes'][] = $note;
                        continue;
                    }

                    if (array_key_exists('translations', $sense)) {
                        if (!array_key_exists('translation', $res[$type])) {
                            $res[$type]['translation'] = [];
                        }

                        foreach ($sense['translations'] as $translation)
                        {
                            $res[$type]['translation'][] = $translation['text'];
                        }
                    }

                    if (array_key_exists('examples', $sense)) {
                        if (!array_key_exists('examples', $res[$type])) {
                            $res[$type]['examples'] = [];
                        }

                        foreach ($sense['examples'] as $example)
                        {
                            foreach ($example['translations'] as $translation)
                            {
                                $res[$type]['examples'][] = [$example['text'] => $translation['text']];
                            }
                        }

                    }

                }
            }
        }

        return $res;
    }

    public function getSynonyms() :array
    {
        $res = [];

        foreach($this->response['results'][0]['lexicalEntries'] as $lexicalEntry)
        {
            $type = $lexicalEntry['lexicalCategory']['id'];
            $res[$type] = [];
            $res[$type]['synonyms'] = [];
            $res[$type]['antonyms'] = [];

            foreach($lexicalEntry['entries'] as $entry)
            {
                foreach($entry['senses'] as $sense)
                {
                    if (array_key_exists('antonyms', $sense)) {
                        foreach ($sense['antonyms'] as $antonym)
                        {
                            $res[$type]['antonyms'][] = $antonym['text'];
                        }
                    }

                    if (array_key_exists('synonyms', $sense)) {
                        foreach ($sense['synonyms'] as $synonyms)
                        {
                            $res[$type]['synonyms'][] = $synonyms['text'];
                        }
                    }
                }
            }
        }

        return $res;
    }
}
