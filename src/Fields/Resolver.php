<?php

namespace Lmr\AutoTranslator\Fields;

use Craft;
use craft\elements\Entry;
use craft\fieldlayoutelements\CustomField;
use Lmr\AutoTranslator\Contracts\FieldInterface;
use Lmr\AutoTranslator\Contracts\FieldResolverInterface;
use Lmr\AutoTranslator\Plugin;

class Resolver implements FieldResolverInterface
{
    /**
     * @param Entry $entry
     * @param string $fieldName
     * @return FieldInterface|null
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function resolve(Entry $entry, string $fieldName): ?FieldInterface
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

        $config = Plugin::getInstance()->getSettings();
        $fieldTypes = $config->fields;

        // Do we have a field type definition of this field?
        if (! isset($fieldTypes[$fieldClassName])) {
            return null;
        }

        // Make an instance of the found field type
        return Craft::$container->get($fieldTypes[$fieldClassName], [$fieldName, $entry]);
    }
}
