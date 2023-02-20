<?php

namespace VampireAPI\Generic\Maps;

class MapList extends \VampireAPI\Generic\RecordList
{
    public function getRandomBuildingType(): string
    {
        $index = array_rand($this->data['buildingType']);
        return $this->data['buildingType'][$index]['type'];
    }

    /**
     * Returns a RecordList containing all possible building types
     *
     * @return MapList
     */
    public function getBuildingTypes(): MapList
    {
        return new MapList($this->data['buildingType']);
    }
}