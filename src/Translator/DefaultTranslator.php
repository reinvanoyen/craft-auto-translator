<?php

namespace Lmr\AutoTranslator\Translator;

use craft\base\Component;
use craft\elements\Entry;
use Lmr\AutoTranslator\Contracts\Policy;
use Lmr\AutoTranslator\Contracts\TranslationService;

class DefaultTranslator extends Component
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
     * @return void
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
    public function scheduleTranslation(Entry $entry)
    {
        if ($this->policy->shouldTranslate($entry)) {
            dd('Should translate!');
        }
    }
}
