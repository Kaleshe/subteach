<?php


namespace Subteach;


class UpdateQueryBuilder extends QueryBuilder
{
    public function __construct($table, $columnsWithType, $props, $bindings)
    {
        parent::__construct($table, $columnsWithType, $props, $bindings);
    }

    public function buildWpdb($set = null, $column_where = null)
    {
        return join(' ',
            ['UPDATE', $this->getTable(),
                $this->buildSet($set),
                $this->buildWhere($column_where)]);
    }

}