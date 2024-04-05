<?php

namespace Lmr\AutoTranslator\Services;

use Lmr\AutoTranslator\Contracts\TranslationService;

class SimpleTranslationService implements TranslationService
{
    public function translate(string $input, string $fromLanguage, string $toLanguage): string
    {
        return 'Vertaald!';
    }
}
