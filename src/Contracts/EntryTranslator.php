<?php

namespace Lmr\AutoTranslator\Contracts;

use craft\elements\Entry;

interface EntryTranslator
{
    public function translate(Entry $originalEntry, Entry $translateEntry, string $fromLanguage, string $toLanguage);
}
