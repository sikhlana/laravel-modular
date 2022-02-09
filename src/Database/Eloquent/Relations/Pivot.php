<?php

namespace Sikhlana\Modular\Database\Eloquent\Relations;

use Illuminate\Database\Eloquent\Relations\Pivot as BasePivot;
use Sikhlana\Modular\Support\ModelTableNameGuesser;

class Pivot extends BasePivot
{
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

        return app()->make(ModelTableNameGuesser::class)->table($this);
    }
}
