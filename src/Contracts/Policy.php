<?php

namespace Lmr\AutoTranslator\Contracts;

use craft\elements\Entry;

interface Policy
{
    public function shouldTranslate(Entry $entry): bool;
}
