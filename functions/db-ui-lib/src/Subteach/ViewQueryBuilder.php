<?php


namespace Subteach;


class ViewQueryBuilder extends QueryBuilder
{

    public function __construct($table, $columnsWithType, $props, $bindings)
    {
        parent::__construct($table, $columnsWithType, $props, $bindings);
    }

    public function buildWpdb($column = null)
    {
        return join(" ", ['SELECT', $this->buildColumns(), $this->buildFrom(), $this->buildWhere($column)]);
    }

}