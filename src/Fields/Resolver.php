<?php

namespace Lmr\AutoTranslator\Fields;

use craft\elements\Entry;
use craft\fieldlayoutelements\CustomField;
use Lmr\AutoTranslator\Contracts\Field;
use Lmr\AutoTranslator\Contracts\FieldResolver;

class Resolver implements FieldResolver
{
    /**
     * @param Entry $entry
     * @param string $fieldName
     * @return Field|null
     */
    public function resolve(Entry $entry, string $fieldName): ?Field
    {
        // Check if we find the field in the default field layout
        $fieldInfo = $entry->getFieldLayout()->getField($fieldName);

        // Looks like we couldn't find it
        if (! $fieldInfo) {
            return null;
        }

        // Get the classname of the field
        $fieldClassName = get_class($fieldInfo);

        // Is it a custom field? Then find it's specific class in the custom fields list
        if ($fieldClassName === CustomField::class) {
            foreach ($entry->getFieldLayout()->getCustomFields() as $c) {
                if ($c->handle === $fieldName) {
                    $fieldClassName = get_class($c);
                    break;
                }
            }
        }

        // Do we have a field type definition of this field?
        if (! isset($fieldTypes[$fieldClassName])) {
            return null;
        }

        // Make an instance of the found field type
        return Craft::$container->get($fieldTypes[$fieldClassName]);
    }
}
