<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa;

use VampireAPI\AbstractRoute;

abstract class AbstractTable extends AbstractRoute
{
    protected array $tableData;

    /**
     * Returns a randomly selected value from the table data.
     *
     * @return string
     */
    protected function roll(): string
    {
        return $this->tableData[array_rand($this->tableData)];
    }
}
