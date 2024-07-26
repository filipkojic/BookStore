<?php

abstract class AbstractEntity
{
    /**
     * Creates an array of objects from a batch of data.
     *
     * @param array $batch
     * @return self[]
     */
    public static function fromBatch(array $batch): array
    {
        $entities = [];
        foreach ($batch as $item) {
            $entities[] = new static(...array_values($item));
        }
        return $entities;
    }

    /**
     * Converts the object to an array.
     *
     * @return array
     */
    public abstract function toArray(): array;
}
