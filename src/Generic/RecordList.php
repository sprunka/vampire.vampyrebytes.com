<?php

namespace VampireAPI\Generic;

use ArrayAccess;
use Countable;
use Iterator;
use ReturnTypeWillChange;
use RuntimeException;
use stdClass;

/**
 * Class RecordList
 * This is a collection type object to hold sets of Records. It can behave like an Object or an Array at your preference.
 * @package VampireAPI\Generic\
 */
class RecordList implements Countable, ArrayAccess, Iterator
{
    protected mixed $data = [];
    protected bool $autoSave = false;
    protected string|bool $saveFile;

    /**
     * RecordList constructor.
     * @param bool|array|string|stdClass $data
     * @param bool $autoSave
     * @param bool $createFile
     * @throws RuntimeException
     */
    public function __construct(bool|array|string|stdClass $data = false, bool $autoSave = false, bool $createFile = false)
    {
        if ($data !== false) {
            $this->loadData($data, $autoSave, $createFile);
        }
    }

    /**
     * @param array|string|stdClass $data
     * @param bool $autoSave
     * @param bool $createFile
     * @return void
     */
    public function loadData(array|string|stdClass $data, bool $autoSave = false, bool $createFile = false)
    {
        if (is_string($data) && (file_exists($data) || $createFile === true)) {
            $this->saveFile = $data;
            if (!file_exists($data)) {
                file_put_contents($data, '{}', LOCK_EX);
            }
            $data = json_decode(file_get_contents($data), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new RuntimeException('Error decoding File: JSON ERROR: ' . json_last_error_msg());
            }
            if ($autoSave !== false) {
                $this->autoSave = 'file';
            }
        }
        if (is_string($data)) {
            $data = json_decode($data, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new RuntimeException('Error decoding string: JSON ERROR: ' . json_last_error_msg());
            }
            if ($autoSave !== false && $this->autoSave === false) {
                $this->autoSave = 'string';
            }
        }
        if (is_array($data) || $data instanceof stdClass) {
            if ($autoSave !== false && $this->autoSave === false) {
                $this->autoSave = 'array';
                if ($data instanceof stdClass) {
                    $this->autoSave = 'stdClass';
                }
            }
            foreach ($data as $key => $value) {
                $record = new Record($value);
                $this->addRecord($record, $key, true);
            }
        }
    }

    /**
     * @param Record $record the Record to add to the List
     * @param bool $key Optional array key to store Record at.
     * @param bool $force If array key already exists, overwrite with new Record?
     * @return bool|mixed
     */
    public function addRecord(Record $record, $key = false, $force = false)
    {
        if ($key === false && !$this->recordExists($record)) {
            $this->data[] = $record;
            if ($this->autoSave !== false) {
                return $this->save();
            }
            return true;
        }

        if ($force === true || array_key_exists($key, $this->data) === false) {
            $this->data[$key] = $record;
            if ($this->autoSave !== false) {
                return $this->save();
            }
            return true;
        }

        return false;
    }

    /**
     * @param Record $record
     * @return bool
     */
    public function recordExists(Record $record): bool
    {
        return in_array($record, $this->data, true);
    }

    /**
     * @param string|null $type
     * @param string|null $saveFile
     * @return false|int|mixed|string
     * @throws RuntimeException
     */
    public function save(string $type = null, string $saveFile = null): mixed
    {
        if (!$type) {
            $type = $this->autoSave;
        }
        if (!$saveFile) {
            $saveFile = $this->saveFile;
        }

        //$out = json_encode($this->data, JSON_PRETTY_PRINT);
        $out = json_encode($this->data);

        switch ($type) {
            case 'string':
                return $out;
                break;
            case 'array':
                return json_decode($out, true);
                break;
            case 'stdClass':
                return json_decode($out, false);
                break;
            case 'file':
                if (!is_string($saveFile)) {
                    throw new RuntimeException('No save file specified.');
                }
                return file_put_contents($saveFile, $out, LOCK_EX);
                break;
            default:
                throw new RuntimeException('Save Type not specified.');
                break;
        }
    }

    /**
     * @param string $filePath Path to the Source File.
     * @param bool $save AutoSave feature, boolean.
     * @return void
     */
    public function loadFile(string $filePath, bool $save = true): void
    {
        $this->loadData($filePath, $save);
    }

    /**
     * @param string|int $key The array key to look up
     * @return mixed
     */
    public function getRecordByKey($key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
        return null;
    }

    /**
     * Look up a Record by one of it's properties
     * NOTE: This will return the first (and only the first) Record with said property/value combo.
     * @param string $property The Record property to look up.
     * @param string $value The Value of the Property we're looking for
     * @return Record|null
     */
    public function getRecordByProperty($property, $value)
    {
        foreach ($this->data as $record) {
            if (property_exists($record, $property) && $record->{$property} === $value) {
                return $record;
            }
        }
        return null;
    }

    /**
     * @param Record $record
     * @return bool|mixed
     */
    public function deleteRecord(Record $record)
    {
        if ($this->recordExists($record)) {
            $key = $this->getRecordKey($record);
            return $this->deleteRecordByKey($key);
        }
        return false;
    }

    /**
     * @param Record $record
     * @return false|int|string
     */
    public function getRecordKey(Record $record)
    {
        return array_search($record, $this->data, true);
    }

    /**
     * @param string|int $key
     * @return bool|mixed
     */
    public function deleteRecordByKey($key)
    {
        if ($this->offsetExists($key)) {
            unset($this->data[$key]);
            if ($this->autoSave !== false) {
                return $this->save();
            }
            return true;
        }
        return false;
    }

    /**
     * @return bool|string
     */
    public function getAutoSave()
    {
        return $this->autoSave;
    }

    /**
     * @param bool|string $autoSave
     */
    public function setAutoSave(bool|string $autoSave)
    {
        $this->autoSave = $autoSave;
    }

    /**
     * @return bool|string
     */
    public function getSaveFile(): bool|string
    {
        return $this->saveFile;
    }

    /**
     * @param string $saveFile
     */
    public function setSaveFile(string $saveFile)
    {
        $this->saveFile = $saveFile;
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset): bool
    {
        return isset($this->data[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * @inheritDoc
     */
    public function current(): mixed
    {
        return current($this->data);
    }

    /**
     * @inheritDoc
     */
    #[ReturnTypeWillChange] public function next()
    {
        return next($this->data);
    }

    /**
     * @inheritDoc
     */
    public function key(): string|int|null
    {
        return key($this->data);
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return $this->offsetExists(key($this->data));
    }

    /**
     * @inheritDoc
     */
    #[ReturnTypeWillChange] public function rewind()
    {
        return reset($this->data);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset): mixed
    {
        return $this->data[$offset] ?? null;
    }

    /**
     * @inheritDoc
     */
    #[ReturnTypeWillChange] public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    /**
     * @inheritDoc
     */
    #[ReturnTypeWillChange] public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}
