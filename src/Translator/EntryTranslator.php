<?php

namespace Lmr\AutoTranslator\Translator;

use Craft;
use craft\elements\Entry;
use craft\errors\ElementNotFoundException;
use Lmr\AutoTranslator\Contracts\EntryTranslatorInterface;
use Lmr\AutoTranslator\Contracts\TranslationServiceInterface;
use Lmr\AutoTranslator\Fields\Resolver;
use Lmr\AutoTranslator\Plugin;
use yii\base\Exception;

class EntryTranslator implements EntryTranslatorInterface
{
    /**
     * @var Resolver $fieldResolver
     */
    private Resolver $fieldResolver;

    /**
     * @var TranslationServiceInterface $service
     */
    private TranslationServiceInterface $service;

    /**
     * @param Resolver $fieldResolver
     * @param TranslationServiceInterface $service
     */
    public function __construct(Resolver $fieldResolver, TranslationServiceInterface $service)
    {
        $this->fieldResolver = $fieldResolver;
        $this->service = $service;
    }

    /**
     * @param Entry $originalEntry
     * @param Entry $translateEntry
     * @param $fromLanguage
     * @param $toLanguage
     * @return void
     * @throws \Throwable
     * @throws ElementNotFoundException
     * @throws Exception
     */
    public function translate(Entry $originalEntry, Entry $translateEntry, $fromLanguage, $toLanguage)
    {
        $handle = $translateEntry->section->handle;

        $config = Plugin::getInstance()->getSettings();
        $translateFields = $config->translate[$handle];

        // Loop through each field and translate its contents
        foreach ($translateFields as $fieldName) {

            $field = $this->fieldResolver->resolve($originalEntry, $fieldName);

            if (!$field) {
                continue;
            }

            // Translate!
            $field->translate($fromLanguage, $toLanguage, $translateEntry);
        }

        // Save the translated entry
        Craft::$app->elements->saveElement($translateEntry);
    }
}
