<?php

namespace Lmr\AutoTranslator\Contracts;

use craft\elements\Entry;

/*
 * Responsible for resolving the entry's field to an implementation of
 * Lmr\AutoTranslator\Contracts\Field specifically for that field
 * */
interface FieldResolverInterface
{
    public function resolve(Entry $entry, string $fieldName): ?FieldInterface;
}
