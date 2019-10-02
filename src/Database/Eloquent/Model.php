<?php

namespace Sikhlana\Modular\Database\Eloquent;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Sikhlana\Modular\Support\ModelTableNameGuesser;

class Model extends BaseModel
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
        if ($this->table) {
            return $this->table;
        }

        return $this->tableNameGuesser->table($this);
    }

    /**
     * Get the joining table name for a many-to-many relation.
     *
     * @param  string  $related
     * @param  BaseModel|null  $instance
     * @return string
     */
    public function joiningTable($related, $instance = null)
    {
        if (is_null($instance)) {
            return parent::joiningTable($related);
        }

        return $this->tableNameGuesser->joiningTable(
            $this, $instance
        );
    }
}
