<?php

namespace Sikhlana\Modular\Database\Eloquent;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Sikhlana\Modular\Support\ModelTableNameGuesser;

class Model extends BaseModel
{
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

        return app()->make(ModelTableNameGuesser::class)->table($this);
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

        return app()->make(ModelTableNameGuesser::class)->joiningTable($this, $instance);
    }
}
