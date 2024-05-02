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

class DefaultEntryTranslatorInterface implements EntryTranslatorInterface
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

        // Loop through each translatable field and
        foreach ($translateFields as $fieldName) {

            $field = $this->fieldResolver->resolve($originalEntry, $fieldName);

            if (!$field) {
                continue;
            }

            $field->translate($fromLanguage, $toLanguage, $translateEntry);

            // Get the original content for this field type and entry
            $content = $field->get($fieldName, $originalEntry);

            // Translate it
            $translated = $this->service->translate($content, $fromLanguage, $toLanguage);

            // Save!
            $field->save($fieldName, $translateEntry, $translated);
        }

        // Save the translated entry
        Craft::$app->elements->saveElement($translateEntry);
    }
}
