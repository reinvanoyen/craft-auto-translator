<?php

return [
    'enabled' => true,
    'fromLanguages' => ['nl'],
    'toLanguages' => ['en'],
    'service' => 'reverse',
    'services' => [
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
        craft\fieldlayoutelements\entries\EntryTitleField::class => \Lmr\AutoTranslator\FieldTypes\TextField::class,
        craft\ckeditor\Field::class => \Lmr\AutoTranslator\FieldTypes\RichtextField::class,
    ],
];
