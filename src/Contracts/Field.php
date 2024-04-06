<?php

namespace Lmr\AutoTranslator\Contracts;

use craft\elements\Entry;

interface Field
{
    /**
     * @param string $name
     * @param Entry $entry
     * @return string
     */
    public function get(string $name, Entry $entry): string;

    /**
     * @param string $name
     * @param Entry $entry
     * @param string $contents
     * @return void
     */
    public function save(string $name, Entry $entry, string $contents): void;
}
