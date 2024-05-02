<?php

namespace Lmr\AutoTranslator\Policies;

use craft\elements\Entry;
use craft\helpers\ElementHelper;
use Lmr\AutoTranslator\Contracts\PolicyInterface;
use Lmr\AutoTranslator\Plugin;

class DefaultPolicy implements PolicyInterface
{
    /**
     * @param Entry $entry
     * @return bool
     */
    public function shouldTranslate(Entry $entry): bool
    {
        $config = Plugin::getInstance()->getSettings();
        $fromLanguages = $config->fromLanguages;

        // The language we've just edited and need to translate from
        $currentLanguage = $entry->site->language;

        // Only translate when the current language is in the list of "from languages"
        if (! in_array($currentLanguage, $fromLanguages)) {
            return false;
        }

        // Only translate when the entry is enabled for the site
        if (! $entry->enabledForSite) {
            return false;
        }

        return ! (ElementHelper::isDraftOrRevision($entry) || $entry->resaving);
    }
}
