<?php

use craft\helpers\App;

return [
    'enabled' => App::env('AUTO_TRANSLATOR_ENABLED') ?: true,
    'fromLanguages' => ['nl'],
    'toLanguages' => ['en'],
    'service' => 'deepl',
    'services' => [
        'deepl' => [
            'class' => Lmr\AutoTranslator\Services\DeeplTranslationService::class,
            'apiKey' => App::env('DEEPL_API_KEY'),
        ],
        'google' => [
            'class' => Lmr\AutoTranslator\Services\GoogleCloudTranslationService::class,
            'project' => App::env('GOOGLE_TRANSLATE_PROJECT'),
            'location' => App::env('GOOGLE_TRANSLATE_LOCATION'),
            'options' => [
                'credentials' => App::env('GOOGLE_TRANSLATE_KEY')
            ],
        ],
        'simple' => [
            'class' => Lmr\AutoTranslator\Services\SimpleTranslationService::class,
        ],
        'reverse' => [
            'class' => Lmr\AutoTranslator\Services\ReverseWordsTranslationService::class,
            'prefix' => '[',
            'suffix' => ']',
        ],
    ],
    'policy' => [
        'class' => Lmr\AutoTranslator\Policies\DefaultPolicy::class,
    ],
    'translate' => [
        'pages' => [
            'title',
        ],
        'cases' => [
            'title',
            'commonTextSimple',
            'commonText',
        ],
    ],
    'fields' => [
        craft\fieldlayoutelements\entries\EntryTitleField::class => Lmr\AutoTranslator\Fields\Types\TextField::class,
        craft\ckeditor\Field::class => Lmr\AutoTranslator\Fields\Types\RichtextField::class,
    ],
];
