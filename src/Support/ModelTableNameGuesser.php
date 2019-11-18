<?php

namespace Sikhlana\Modular\Support;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ModelTableNameGuesser
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * Cache of guessed table names.
     *
     * @var array
     */
    protected $tableNameCache = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function table(Model $model)
    {
        $class = get_class($model);

        if (isset($this->tableNameCache[$class])) {
            return $this->tableNameCache[$class];
        }

        $table = str_replace(
            '\\', '', substr(
                $class, strlen(
                    trim($this->app->getNamespace(), '\\').'\\'.config('modular.namespaces.models')
                )
            )
        );

        if (! ($model instanceof Pivot)) {
            $table = Str::pluralStudly($table);
        }

        $table = Str::snake($table);
        $this->tableNameCache[$class] = $table;

        return $table;
    }

    public function joiningTable(Model $first, Model $second)
    {
        $tables = [$first->getTable(), $second->getTable()];
        sort($tables, SORT_NATURAL);

        [$first, $second] = $tables;
        $cacheKey = $first.':'.$second;

        if (isset($this->tableNameCache[$cacheKey])) {
            return $this->tableNameCache[$cacheKey];
        }

        $prefix = '';
        $length = strlen($first);

        for ($i = 0; $i < $length; $i++) {
            if ($first[$i] !== $second[$i]) {
                break;
            }

            $prefix .= $first[$i];
        }

        $first = Str::singular($first);
        $second = Str::singular($second);

        if ($prefix !== '') {
            $start = Str::length($prefix);

            $first = Str::substr($first, $start);
            $second = Str::substr($second, $start);
        }

        $table = $prefix.$first.'_'.$second;
        $this->tableNameCache[$cacheKey] = $table;

        return $table;
    }
}
