<?php

use Illuminate\Support\Collection;

/*
 * Splits a collection into sections grouped by a given key.
 *
 * @param mixed $key
 * @param bool $preserveKeys
 * @param mixed $sectionKey
 * @param mixed $itemsKey
 *
 * @return \Illuminate\Support\Collection
 */
Collection::macro('sectionBy', function ($key, $preserveKeys = false, $sectionKey = 0, $itemsKey = 1): Collection {
    $sectionNameRetriever = $this->valueRetriever($key);

    $results = new Collection();

    foreach ($this->items as $key => $value) {
        $sectionName = $sectionNameRetriever($value);

        if (! $results->last() || $results->last()->get($sectionKey) !== $sectionName) {
            $results->push(new Collection([
                $sectionKey => $sectionName,
                $itemsKey => new Collection(),
            ]));
        }

        $results->last()->get($itemsKey)->offsetSet($preserveKeys ? $key : null, $value);
    }

    return $results;
});
