<?php

namespace Lmr\AutoTranslator\Models;

use craft\base\Model;
use craft\fieldlayoutelements\entries\EntryTitleField;
use craft\fields\PlainText;
use craft\fields\Table;
use Lmr\AutoTranslator\Fields\Types\RichtextField;
use Lmr\AutoTranslator\Fields\Types\TableField;
use Lmr\AutoTranslator\Fields\Types\TextField;
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
    public array $fromLanguages = [];

    /**
     * @var array $toLanguages
     */
    public array $toLanguages = [];

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
    public array $translate = [];

    /**
     * @var array $fields
     */
    public array $fields = [
        PlainText::class => TextField::class,
        EntryTitleField::class => TextField::class,
        Table::class => TableField::class,
        \craft\ckeditor\Field::class => RichtextField::class,
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
