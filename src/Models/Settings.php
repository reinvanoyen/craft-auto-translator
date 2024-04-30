<?php

namespace Lmr\AutoTranslator\Models;

use craft\base\Model;
use Lmr\AutoTranslator\Services\ReverseWordsTranslationService;

/**
 * Class Settings
 * */
class Settings extends Model
{
    /**
     * @var bool $enabled
     */
    public bool $enabled = true;

    /**
     * @var array $fromLanguages
     */
    public array $fromLanguages = ['nl'];

    /**
     * @var array $toLanguages
     */
    public array $toLanguages = ['en'];

    /**
     * @var string $service
     */
    public string $service = 'deepl';

    /**
     * @var array $policy
     */
    public array $policy = [
        'class' => \Lmr\AutoTranslator\Policies\DefaultPolicy::class,
    ];

    /**
     * @var array $services
     */
    public array $services = [
        'deepl' => [
            'class' => \Lmr\AutoTranslator\Services\DeeplTranslationService::class,
            'apiKey' => '05727dce-9cdc-4ca3-be6f-260f740fed54:fx',
        ],
        'google' => [
            'class' => \Lmr\AutoTranslator\Services\GoogleCloudTranslationService::class,
            'project' => '$GOOGLE_TRANSLATE_PROJECT',
            'location' => '$GOOGLE_TRANSLATE_LOCATION',
            'options' => [
                'credentials' => 'GOOGLE_TRANSLATE_KEY',
            ],
        ],
        'reverse' => [
            'class' => ReverseWordsTranslationService::class,
        ],
    ];

    /**
     * @var array $translate
     */
    public array $translate = [
        'pages' => [
            'title',
        ],
        'cases' => [
            'title',
            'commonTextSimple',
            'commonText',
        ],
    ];

    /**
     * @var array $fields
     */
    public array $fields = [
        \craft\fieldlayoutelements\entries\EntryTitleField::class => \Lmr\AutoTranslator\Fields\Types\TextField::class,
        \craft\ckeditor\Field::class => \Lmr\AutoTranslator\Fields\Types\RichtextField::class,
    ];

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
