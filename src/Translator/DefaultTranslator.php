<?php

namespace Lmr\AutoTranslator\Translator;

use Craft;
use craft\elements\Entry;
use craft\fieldlayoutelements\CustomField;
use Lmr\AutoTranslator\Contracts\Policy;
use Lmr\AutoTranslator\Contracts\TranslationService;
use Lmr\AutoTranslator\Plugin;

class DefaultTranslator
{
    /**
     * @var Policy $policy
     */
    public Policy $policy;

    /**
     * @var TranslationService $service
     */
    public TranslationService $service;

    /**
     * @param Policy $policy
     * @param TranslationService $service
     * @param array $config
     */
    public function __construct(Policy $policy, TranslationService $service)
    {
        $this->policy = $policy;
        $this->service = $service;
    }

    /**
     * @param Entry $entry
     * @return void
     * @throws \Exception
     */
    public function queueTranslation(Entry $entry): void
    {
        if ($this->policy->shouldTranslate($entry)) {

            $handle = $entry->section->handle;

            $config = Plugin::getInstance()->getSettings();
            $toLanguages = $config->toLanguages;
            $translateFields = $config->translate[$handle];
            $fieldTypes = $config->fields;

            $section = Craft::$app->getSections()->getSectionByHandle($handle);

            if (! $section) {
                throw new \Exception('Section does not exist.');
            }

            // Get the site ids for this section
            // This way, we only translate to the active languages for this section.
            $siteIds = $section->getSiteIds();

            // Loop over our site ids and get the corresponding languages
            foreach ($siteIds as $siteId) {
                $site = Craft::$app->getSites()->getSiteById($siteId);
                if ($site && $site->enabled) {

                    // If the language of the site is not in the "to languages", don't do anything
                    if (! in_array($site->language, $toLanguages)) {
                        continue;
                    }

                    // Get the entry for the current language in the loop
                    $entryToTranslate = Entry::find()
                        ->section($section)
                        ->siteId($site->id)
                        ->id($entry->id);

                    if (! $entryToTranslate->exists()) {
                        continue;
                    }

                    $entryToTranslate = $entryToTranslate->one();

                    foreach ($translateFields as $field) {

                        $fieldInfo = $entryToTranslate->getFieldLayout()->getField($field);

                        if (! $fieldInfo) {
                            continue;
                        }

                        $fieldClassName = get_class($fieldInfo);

                        if ($fieldClassName === CustomField::class) {
                            foreach ($entryToTranslate->getFieldLayout()->getCustomFields() as $c) {
                                if ($c->handle === $field) {
                                    $fieldClassName = get_class($c);
                                }
                            }
                        }

                        if (! isset($fieldTypes[$fieldClassName])) {
                            continue;
                        }

                        // Make an instance of the correct field type
                        $fieldType = Craft::$container->get($fieldTypes[$fieldClassName]);

                        // Get the original content for this field type and entry
                        $content = $fieldType->get($field, $entry);

                        // Translate it
                        $translated = $this->service->translate($content, $entry->site->language, $site->language);

                        // Save!
                        $fieldType->save($field, $entryToTranslate, $translated);
                    }

                    // Save the translated entry
                    Craft::$app->elements->saveElement($entryToTranslate);
                }
            }
        }
    }
}
