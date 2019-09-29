<?php

namespace Sikhlana\Modular\Database\Eloquent\Relations;

use Illuminate\Database\Eloquent\Relations\Pivot as BasePivot;
use Illuminate\Support\Str;

class Pivot extends BasePivot
{
    private static $resolvedTables = [];

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

        if (! isset(self::$resolvedTables[static::class])) {
            $class = substr(
                static::class, strlen(
                    config('modular.models.namespace')
                )
            );

            self::$resolvedTables[static::class] = Str::snake(Str::studly(
                str_replace('\\', '', $class)
            ));
        }

        return self::$resolvedTables[static::class];
    }
}
