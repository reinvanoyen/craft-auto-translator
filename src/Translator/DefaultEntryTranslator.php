<?php

namespace Lmr\AutoTranslator\Translator;

use Craft;
use craft\elements\Entry;
use Lmr\AutoTranslator\Contracts\EntryTranslator;
use Lmr\AutoTranslator\Contracts\TranslationService;
use Lmr\AutoTranslator\Fields\Resolver;
use Lmr\AutoTranslator\Plugin;

class DefaultEntryTranslator implements EntryTranslator
{
    /**
     * @var Resolver $fieldResolver
     */
    private Resolver $fieldResolver;

    /**
     * @var TranslationService $service
     */
    private TranslationService $service;

    /**
     * @param Resolver $fieldResolver
     * @param TranslationService $service
     */
    public function __construct(Resolver $fieldResolver, TranslationService $service)
    {
        $this->fieldResolver = $fieldResolver;
        $this->service = $service;
    }

    /**
     * @param Entry $entry
     * @param $fromLanguage
     * @param $toLanguage
     * @return void
     * @throws \Throwable
     * @throws \craft\errors\ElementNotFoundException
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function translate(Entry $entry, $fromLanguage, $toLanguage)
    {
        $handle = $entry->section->handle;

        $config = Plugin::getInstance()->getSettings();
        $translateFields = $config->translate[$handle];

        foreach ($translateFields as $field) {

            $fieldType = $this->fieldResolver->resolve($entry, $field);

            // Get the original content for this field type and entry
            $content = $fieldType->get($field, $entry);

            // Translate it
            $translated = $this->service->translate($content, $fromLanguage, $toLanguage);

            // Save!
            $fieldType->save($field, $entry, $translated);
        }

        // Save the translated entry
        Craft::$app->elements->saveElement($entry);
    }
}
