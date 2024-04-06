<?php

return [
    'enabled' => true,
    'fromLanguages' => ['nl'],
    'toLanguages' => ['en'],
    'service' => 'google',
    'services' => [
        'google' => [
            'class' => \Lmr\AutoTranslator\Services\GoogleCloudTranslationService::class,
            'project' => \craft\helpers\App::env('GOOGLE_TRANSLATE_PROJECT'),
            'location' => \craft\helpers\App::env('GOOGLE_TRANSLATE_LOCATION'),
            'options' => [
                'credentials' => \craft\helpers\App::env('GOOGLE_TRANSLATE_KEY')
            ],
        ],
        'simple' => [
            'class' => \Lmr\AutoTranslator\Services\SimpleTranslationService::class,
        ],
        'reverse' => [
            'class' => \Lmr\AutoTranslator\Services\ReverseWordsTranslationService::class,
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
        craft\fieldlayoutelements\entries\EntryTitleField::class => \Lmr\AutoTranslator\FieldTypes\TextField::class,
        craft\ckeditor\Field::class => \Lmr\AutoTranslator\FieldTypes\RichtextField::class,
    ],
];
