<?php

namespace Lmr\AutoTranslator\Contracts;

interface TranslationServiceInterface
{
    public function translate(string $input, string $fromLanguage, string $toLanguage): string;
}
