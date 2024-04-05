<?php

namespace Lmr\AutoTranslator\Models;

use craft\base\Model;

/**
 * Class Settings
 *
 * @package percipiolondon\colourswatches\models
 */
class Settings extends Model
{
    /**
     * @var bool $enabled
     */
    public bool $enabled;

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
     * @var array $translatables
     */
    public array $translate;

    /**
     * @return array[]
     */
    protected function defineRules(): array
    {
        return [
            [['enabled', 'service', 'services', 'policy', 'translate'], 'required'],
        ];
    }
}
