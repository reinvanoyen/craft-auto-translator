<?php

namespace Lmr\AutoTranslator\Fields\Types;

use craft\elements\Entry;
use Lmr\AutoTranslator\Contracts\FieldInterface;
use Lmr\AutoTranslator\Fields\Field;

class RichtextField extends Field implements FieldInterface
{
    /**
     * @param string $fromLanguage
     * @param string $toLanguage
     * @param Entry $translateEntry
     * @return void
     */
    public function translate(string $fromLanguage, string $toLanguage, Entry $translateEntry): void
    {
        // Get the original content for this field and entry
        $content = $this->get();

        // Translate it
        $translatedContent = $this->service->translate($content, $fromLanguage, $toLanguage);

        // Save!
        $this->save($translateEntry, $translatedContent);
    }

    /**
     * @return string
     */
    private function get(): string
    {
        $field = $this->originalEntry->{$this->name};

        return strip_tags($field->getRawContent());
    }

    /**
     * @param Entry $translateEntry
     * @param string $contents
     * @return void
     */
    private function save(Entry $translateEntry, string $contents): void
    {
        $translateEntry->{$this->name} = $contents;
    }
}
