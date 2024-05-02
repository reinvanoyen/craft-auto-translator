<?php

namespace Lmr\AutoTranslator\Contracts;

use craft\elements\Entry;

interface PolicyInterface
{
    public function shouldTranslate(Entry $entry): bool;
}
