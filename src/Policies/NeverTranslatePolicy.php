<?php

namespace Lmr\AutoTranslator\Policies;

use craft\elements\Entry;
use Lmr\AutoTranslator\Contracts\PolicyInterface;

class NeverTranslatePolicy implements PolicyInterface
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
