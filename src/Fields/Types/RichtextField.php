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
     * @throws \craft\errors\InvalidFieldException
     */
    public function translate(string $fromLanguage, string $toLanguage, Entry $translateEntry): void
    {
        // Get the original content for this field and entry
        $field = $this->originalEntry->{$this->handle};
        $content = strip_tags($field->getRawContent());

        // Translate it
        $translatedContent = $this->service->translate($content, $fromLanguage, $toLanguage);

        // Save!
        $translateEntry->{$this->handle} = $translatedContent;
    }
}
