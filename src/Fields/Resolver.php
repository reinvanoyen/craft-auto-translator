<?php

namespace Lmr\AutoTranslator\Fields;

use Craft;
use craft\elements\Entry;
use craft\fieldlayoutelements\BaseField;
use craft\fieldlayoutelements\CustomField;
use craft\base\FieldInterface as CraftFieldInterface;
use Lmr\AutoTranslator\Contracts\FieldInterface;
use Lmr\AutoTranslator\Contracts\FieldResolverInterface;
use Lmr\AutoTranslator\Plugin;
use yii\base\InvalidArgumentException;

class Resolver implements FieldResolverInterface
{
    /**
     * @param Entry $entry
     * @param string $handle
     * @return CraftFieldInterface|BaseField|null
     */
    public function getFieldInstance(Entry $entry, string $handle): CraftFieldInterface | BaseField | null
    {
        try {
            // Check if we find the field in the default field layout
            $field = $entry->getFieldLayout()->getField($handle);
        } catch (InvalidArgumentException $e) {
            // We couldn't find it
            return null;
        }

        // Is it a custom field? Then find it's specific class in the custom fields list
        if ($field instanceof CustomField) {
            foreach ($entry->getFieldLayout()->getCustomFields() as $c) {
                if ($c->handle === $handle) {
                    $field =  $c;
                    break;
                }
            }
        }

        return $field;
    }

    /**
     * @param Entry $entry
     * @param string $handle
     * @return FieldInterface|null
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function resolve(Entry $entry, string $handle): ?FieldInterface
    {
        $field = $this->getFieldInstance($entry, $handle);

        if (! $field) {
            return null;
        }

        $fieldClassName = get_class($field);
        $config = Plugin::getInstance()->getSettings();
        $fieldTypes = $config->fields;

        // Do we have a field type definition of this field?
        if (! isset($fieldTypes[$fieldClassName])) {
            return null;
        }

        // Make an instance of the found field type
        return Craft::$container->get($fieldTypes[$fieldClassName], [$handle, $entry]);
    }
}
