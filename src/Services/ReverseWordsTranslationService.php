<?php

namespace Lmr\AutoTranslator\Services;

use Lmr\AutoTranslator\Contracts\TranslationService;

class ReverseWordsTranslationService implements TranslationService
{
    /**
     * @param string $prefix
     * @param string $suffix
     */
    public function __construct(string $prefix = '', string $suffix = '')
    {
        $this->prefix = $prefix;
        $this->suffix = $suffix;
    }

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
