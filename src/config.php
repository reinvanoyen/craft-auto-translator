<?php

use craft\fields\PlainText;
use craft\fields\Table;
use craft\fieldlayoutelements\entries\EntryTitleField;
use Lmr\AutoTranslator\Fields\Types\TextField;
use Lmr\AutoTranslator\Fields\Types\RichtextField;
use Lmr\AutoTranslator\Fields\Types\TableField;

return [
    /**
     * A multidimensional array with as key the section handle name
     * and as value an array of field handles to translate
     *
     * E.g.
     * [
     *   'pages' => ['title', 'description'],
     *   'projects' => ['title', 'description', 'text'],
     * ]
     */
    'translate' => [],

    /**
     * The supported fields and their corresponding classes
     * responsible for their translations
     */
    'fields' => [
        PlainText::class => TextField::class,
        Table::class => TableField::class,
        EntryTitleField::class => TextField::class,
        \craft\ckeditor\Field::class => RichtextField::class,
    ]
];
