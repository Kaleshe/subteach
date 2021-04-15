<?php


namespace Subteach;



class QueryBuilder
{
    private $columnsWithType;
    private $table;
    private $props;
    private $bindings;


    public function __construct($table, $columnsWithType, $props, $bindings)
    {
        $this->table = $table;
        $this->columnsWithType = $columnsWithType;
        $this->props = $props;
        $this->bindings = $bindings;
    }

    public static function placeholderFor($type)
    {
        $placeholderMap = ["int" => "%d", "string" => "%s"];
        if(key_exists($type, $placeholderMap)) {
            return $placeholderMap[$type];
        }

        return null;
    }

    public function getColumnPlaceholder($column)
    {
        return self::placeholderFor($this->getColumnType($column));
    }

    public function getTable() : string
    {
        return $this->table;
    }



    public function buildSet($columns)
    {
        if($columns === null) {
            return '';
        }

        $set = [];

        foreach($columns as $column)
        {
            $type = $this->getColumnPlaceholder($column);
            $set []= "$column=$type";
        }

        return 'SET ' . join(',', $set);
    }

    protected function buildWhere(?string $column)
    {
        if($column === null)
        {
            return '';
        }

        $placeholder = $this->getColumnPlaceholder($column);
        return "WHERE $column = $placeholder";
    }

    protected function buildColumns()
    {
        return join(',', $this->getColumns());
    }

    protected function buildFrom()
    {
        return "FROM $this->table";
    }

    protected function getColumns()
    {
        return array_keys($this->columnsWithType);
    }

    private function getColumnType($column)
    {
        return $this->columnsWithType[$column];
    }
}