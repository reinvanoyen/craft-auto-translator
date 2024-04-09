<?php

namespace Lmr\AutoTranslator\Fields\Types;

use craft\elements\Entry;
use Lmr\AutoTranslator\Contracts\Field;

class RichtextField implements Field
{
    /**
     * @param string $name
     * @param Entry $entry
     * @return string
     */
    public function get(string $name, Entry $entry): string
    {
        return strip_tags($entry->{$name}->getRawContent());
    }

    /**
     * @param string $name
     * @param Entry $entry
     * @param string $contents
     * @return void
     */
    public function save(string $name, Entry $entry, string $contents): void
    {
        $entry->{$name} = $contents;
    }
}
