<?php

namespace Lmr\AutoTranslator\Contracts;

interface TranslationService
{
    public function translate(string $input, string $fromLanguage, string $toLanguage): string;
}
