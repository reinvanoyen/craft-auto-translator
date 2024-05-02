<?php

namespace Lmr\AutoTranslator\Fields;

use craft\elements\Entry;
use Lmr\AutoTranslator\Contracts\TranslationServiceInterface;

abstract class Field
{
    /**
     * @var string $name
     */
    protected string $name;

    /**
     * @var Entry $originalEntry
     */
    protected Entry $originalEntry;

    /**
     * @var TranslationServiceInterface $service
     */
    protected TranslationServiceInterface $service;

    /**
     * @param string $name
     * @param Entry $originalEntry
     * @param TranslationServiceInterface $service
     */
    public function __construct(string $name, Entry $originalEntry, TranslationServiceInterface $service)
    {
        $this->name = $name;
        $this->originalEntry = $originalEntry;
        $this->service = $service;
    }
}
