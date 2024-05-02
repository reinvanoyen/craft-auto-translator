<?php

namespace Lmr\AutoTranslator\Translator;

use Craft;
use craft\elements\Entry;
use Lmr\AutoTranslator\Contracts\PolicyInterface;
use Lmr\AutoTranslator\Plugin;

class DefaultTranslator
{
    /**
     * @var PolicyInterface $policy
     */
    public PolicyInterface $policy;

    /**
     * @var EntryTranslator $entryTranslator
     */
    public EntryTranslator $entryTranslator;

    /**
     * @param PolicyInterface $policy
     * @param EntryTranslator $entryTranslator
     */
    public function __construct(PolicyInterface $policy, EntryTranslator $entryTranslator)
    {
        $this->policy = $policy;
        $this->entryTranslator = $entryTranslator;
    }

    /**
     * @param Entry $entry
     * @return void
     * @throws \Throwable
     * @throws \craft\errors\ElementNotFoundException
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function queueTranslation(Entry $entry): void
    {
        if ($this->policy->shouldTranslate($entry)) {

            $handle = $entry->section->handle;

            $config = Plugin::getInstance()->getSettings();
            $toLanguages = $config->toLanguages;

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

                    // Translate the entry
                    $this->entryTranslator->translate($entry, $entryToTranslate, $entry->site->language, $site->language);
                }
            }
        }
    }
}
