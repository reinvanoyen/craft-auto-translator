<?php

namespace Lmr\AutoTranslator\Fields;

use craft\elements\Entry;
use Lmr\AutoTranslator\Contracts\TranslationServiceInterface;

abstract class Field
{
    /**
     * @var string $handle
     */
    protected string $handle;

    /**
     * @var Entry $originalEntry
     */
    protected Entry $originalEntry;

    /**
     * @var TranslationServiceInterface $service
     */
    protected TranslationServiceInterface $service;

    /**
     * @param string $handle
     * @param Entry $originalEntry
     * @param TranslationServiceInterface $service
     */
    public function __construct(string $handle, Entry $originalEntry, TranslationServiceInterface $service)
    {
        $this->handle = $handle;
        $this->originalEntry = $originalEntry;
        $this->service = $service;
    }
}
