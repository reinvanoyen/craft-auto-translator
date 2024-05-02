<?php

namespace Lmr\AutoTranslator\Contracts;

use craft\elements\Entry;

interface FieldInterface
{
    /**
     * @param string $name
     * @param Entry $originalEntry
     * @param TranslationServiceInterface $service
     */
    public function __construct(string $name, Entry $originalEntry, TranslationServiceInterface $service);

    /**
     * @param string $fromLanguage
     * @param string $toLanguage
     * @param Entry $translateEntry
     * @return void
     */
    public function translate(string $fromLanguage, string $toLanguage, Entry $translateEntry): void;
}
