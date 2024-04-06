<?php

namespace Lmr\AutoTranslator\Services;

use DeepL\Translator;
use Lmr\AutoTranslator\Contracts\TranslationService;

class DeeplTranslationService implements TranslationService
{
    /**
     * @var string $key
     */
    public string $apiKey;

    /**
     * @param string $input
     * @param string $fromLanguage
     * @param string $toLanguage
     * @return string
     * @throws \DeepL\DeepLException
     */
    public function translate(string $input, string $fromLanguage, string $toLanguage): string
    {
        $languageMap = [
            'en' => 'en-US',
            'pt' => 'pt-PT',
        ];

        $fromLanguage = $languageMap[$fromLanguage] ?? $fromLanguage;
        $toLanguage = $languageMap[$toLanguage] ?? $toLanguage;

        // Create the client
        $client = new Translator($this->apiKey);

        $result = $client->translateText($input, $fromLanguage, $toLanguage);
        return $result->text;
    }
}
