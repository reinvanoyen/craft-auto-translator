<?php

namespace Lmr\AutoTranslator\Contracts;

use craft\base\FieldInterface as CraftFieldInterface;
use craft\elements\Entry;
use craft\fieldlayoutelements\BaseField;

/*
 * Responsible for resolving the entry's field to an implementation of
 * Lmr\AutoTranslator\Contracts\Field specifically for that field
 * */
interface FieldResolverInterface
{
    /**
     * @param Entry $entry
     * @param string $handle
     * @return CraftFieldInterface|BaseField|null
     */
    public function getFieldInstance(Entry $entry, string $handle): CraftFieldInterface | BaseField | null;

    /**
     * @param Entry $entry
     * @param string $handle
     * @return FieldInterface|null
     */
    public function resolve(Entry $entry, string $handle): ?FieldInterface;
}
