<?php

namespace Lmr\AutoTranslator\Policies;

use craft\elements\Entry;
use Lmr\AutoTranslator\Contracts\Policy;

class NeverTranslatePolicy implements Policy
{
    /**
     * @param Entry $entry
     * @return bool
     */
    public function shouldTranslate(Entry $entry): bool
    {
        return false;
    }
}
