<?php

namespace Lmr\AutoTranslator\Policies;

use craft\elements\Entry;
use Lmr\AutoTranslator\Contracts\PolicyInterface;

class AlwaysTranslatePolicy implements PolicyInterface
{
    /**
     * @param Entry $entry
     * @return bool
     */
    public function shouldTranslate(Entry $entry): bool
    {
        return true;
    }
}
