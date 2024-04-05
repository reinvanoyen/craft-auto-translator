<?php

namespace Lmr\AutoTranslator\Translator;

use craft\elements\Entry;
use Lmr\AutoTranslator\Contracts\Policy;
use Lmr\AutoTranslator\Contracts\TranslationService;

class DefaultTranslator
{
    /**
     * @var Policy $policy
     */
    public Policy $policy;

    /**
     * @var TranslationService $service
     */
    public TranslationService $service;

    /**
     * @param Policy $policy
     * @param TranslationService $service
     * @param array $config
     */
    public function __construct(Policy $policy, TranslationService $service)
    {
        $this->policy = $policy;
        $this->service = $service;
    }

    /**
     * @param Entry $entry
     * @return void
     */
    public function scheduleTranslation(Entry $entry): void
    {
        if ($this->policy->shouldTranslate($entry)) {
            // @TODO
        }
    }
}
