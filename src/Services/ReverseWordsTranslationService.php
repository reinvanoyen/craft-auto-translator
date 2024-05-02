<?php

namespace Lmr\AutoTranslator\Services;

use Lmr\AutoTranslator\Contracts\TranslationServiceInterface;

class ReverseWordsTranslationService implements TranslationServiceInterface
{
    /**
     * @param string $input
     * @param string $fromLanguage
     * @param string $toLanguage
     * @return string
     */
    public function translate(string $input, string $fromLanguage, string $toLanguage): string
    {
        $output = [];
        $words = explode(' ', $input);
        foreach ($words as $word) {
            $output[] = strrev($word);
        }

        return implode(' ', $output);
    }
}
