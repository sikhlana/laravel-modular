<?php

namespace Sikhlana\Modular\Database\Eloquent;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Model extends BaseModel
{
    private static $resolvedTables = [];

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

        if (! isset(self::$resolvedTables[static::class])) {
            $class = substr(
                static::class, strlen(
                    config('modular.models.namespace')
                )
            );

            self::$resolvedTables[static::class] = Str::snake(Str::pluralStudly(
                str_replace('\\', '', $class)
            ));
        }

        return self::$resolvedTables[static::class];
    }

    private static $resolvedJoiningTables = [];

    /**
     * Get the joining table name for a many-to-many relation.
     *
     * @param  string  $related
     * @param  \Illuminate\Database\Eloquent\Model|null  $instance
     * @return string
     */
    public function joiningTable($related, $instance = null)
    {
        $table = parent::joiningTable($related, $instance);

        if (is_null($instance)) {
            return $table;
        }

        $key = implode('', Arr::sort([
            get_class($this), get_class($instance),
        ]));

        if (! isset(self::$resolvedJoiningTables[$key])) {
            $first = $this->getTable();
            $second = $instance->getTable();

            if (strlen($second) < strlen($first)) {
                [$first, $second] = [$second, $first];
            }

            $prefix = '';
            $length = strlen($first);

            for ($i = 0; $i < $length; $i++) {
                if ($first[$i] === $second[$i]) {
                    $prefix .= $first[$i];
                    continue;
                }

                break;
            }

            if ($prefix) {
                $prefix = rtrim($prefix, '_').'_';
            }

            self::$resolvedJoiningTables[$key] = $prefix.$table;
        }

        return self::$resolvedJoiningTables[$key];
    }
}
