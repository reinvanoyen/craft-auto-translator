<?php

namespace Lmr\AutoTranslator\Models;

use craft\base\Model;

/**
 * Class Settings
 * */
class Settings extends Model
{
    /**
     * @var bool $enabled
     */
    public bool $enabled;

    /**
     * @var array $fromLanguages
     */
    public array $fromLanguages;

    /**
     * @var array $toLanguages
     */
    public array $toLanguages;

    /**
     * @var string $service
     */
    public string $service;

    /**
     * @var array $policy
     */
    public array $policy;

    /**
     * @var array $services
     */
    public array $services;

    /**
     * @var array $translate
     */
    public array $translate;

    /**
     * @var array $fields
     */
    public array $fields;

    /**
     * @return array[]
     */
    protected function defineRules(): array
    {
        return [
            [['enabled', 'fromLanguages', 'toLanguages', 'service', 'services', 'policy', 'translate', 'fields',], 'required'],
        ];
    }
}
