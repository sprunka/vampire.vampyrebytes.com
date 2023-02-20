<?php

namespace VampireAPI\Generic;

use stdClass;

class RecordFactory
{
    /**
     * Creates a new Record or a child class of Record with the given data.
     *
     * @param bool|string|array|stdClass $json The data to create the Record from.
     * @param string $recordType The name of the class to create. Must be a child of Record.
     * @return Record The created Record object.
     * @throws \InvalidArgumentException If $recordType is not a child of Record or does not exist.
     */
    public static function create($json = false, string $recordType = Record::class): Record
    {
        if (!is_subclass_of($recordType, Record::class)) {
            throw new \InvalidArgumentException("$recordType must be a child of Record.");
        }

        if (!class_exists($recordType)) {
            throw new \InvalidArgumentException("$recordType does not exist.");
        }

        return new $recordType($json);
    }
}
