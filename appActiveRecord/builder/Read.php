<?php

namespace GabrielBinottiActiveRecord\builder;

use Exception;
use GabrielBinottiActiveRecord\interfaces\InterfaceActiveRecord;

class Read extends Builder
{

    private $table      = null;
    private $fields     = null;
    private $isnull     = null;
    private $limit      = null;
    private $orderBy    = null;
    private $groupBy    = null;
    private $join       = [];

    private function __construct()
    {
    }

    public static function select($fields = '*')
    {
        $self = new self;
        $self->fields = $fields;

        return $self;
    }

    public function from($table)
    {
        $this->table = $table;

        return $this;
    }

    public function isNull($field, $isNull = true)
    {
        if ($isNull) {
            $this->isnull = " {$field} IS NULL";
        } else {
            $this->isnull = " {$field} IS NOT NULL";
        }

        return $this;
    }

    public function join($foreignTable, $foreignAttribute, $attribute, $typeJoin = 'INNER')
    {
        $this->join[] = " {$typeJoin} JOIN {$foreignTable} ON {$foreignAttribute} = {$attribute}";
        return $this;
    }

    public function limit($limit, $offset = null)
    {
        if ($offset) {
            $this->limit = " LIMIT {$limit} OFFSET {$offset}";
        } else {
            $this->limit = " LIMIT {$limit}";
        }

        return $this;
    }

    public function orderBy($field)
    {
        $this->orderBy = " ORDER BY {$field}";

        return $this;
    }

    public function groupBy($field)
    {
        $this->orderBy = " GROUP BY {$field}";

        return $this;
    }


    private function createQuery()
    {

        if (!$this->fields) {
            throw new Exception('You need to call the method select() before.');
        }

        if (!$this->table) {
            throw new Exception('You need to call the method from() before.');
        }

        $query = 'SELECT ';
        $query .= $this->fields . " FROM ";
        $query .= $this->table;
        $query .= ($this->join)      ? implode("", $this->join) : '';
        $query .= ($this->where)     ? ' WHERE ' . implode('', $this->where) : '';
        $query .= ($this->isnull)   ?? '';
        $query .= ($this->groupBy)  ?? '';
        $query .= ($this->orderBy)  ?? '';
        $query .= ($this->limit)    ?? '';

        return $query;
    }

    public function find(InterfaceActiveRecord $interface)
    {

        $query = $this->createQuery();

        try {
            $result = $this->execute($query, $interface);

            return $result;
        } catch (Exception $e) {
            echo "Erro: $e";
        }
    }

    public function findAll(InterfaceActiveRecord $interface)
    {
        $query = $this->createQuery();

        try {
            $result = $this->execute($query, $interface);

            return $result;
        } catch (Exception $e) {
            echo "Erro: $e";
        }
    }
}
