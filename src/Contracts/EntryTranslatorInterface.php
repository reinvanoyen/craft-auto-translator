<?php

namespace Lmr\AutoTranslator\Contracts;

use craft\elements\Entry;

interface EntryTranslatorInterface
{
    public function translate(Entry $originalEntry, Entry $translateEntry, string $fromLanguage, string $toLanguage);
}
