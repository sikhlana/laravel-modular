<?php

namespace Sikhlana\Modular\Database\Eloquent\Relations;

use Illuminate\Database\Eloquent\Relations\Pivot as BasePivot;
use Sikhlana\Modular\Support\ModelTableNameGuesser;

class Pivot extends BasePivot
{
    /**
     * @var ModelTableNameGuesser
     */
    protected $tableNameGuesser;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->tableNameGuesser = app()->make(
            ModelTableNameGuesser::class
        );
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        if (isset($this->table)) {
            return $this->table;
        }

        return $this->tableNameGuesser->table($this);
    }
}
