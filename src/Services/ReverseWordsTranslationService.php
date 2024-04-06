<?php

namespace Lmr\AutoTranslator\Services;

use Lmr\AutoTranslator\Contracts\TranslationService;

class ReverseWordsTranslationService implements TranslationService
{
    /**
     * @var string $prefix
     */
    public string $prefix;

    /**
     * @var string $suffix
     */
    public string $suffix;

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

        return $this->prefix . implode(' ', $output) . $this->suffix;
    }
}
