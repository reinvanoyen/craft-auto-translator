<?php

namespace Lmr\AutoTranslator\Contracts;

use craft\elements\Entry;

interface EntryTranslator
{
    public function translate(Entry $entry, string $fromLanguage, string $toLanguage);
}
