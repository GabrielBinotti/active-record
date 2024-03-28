<?php

namespace GabrielBinottiActiveRecord\builder;

use Exception;
use GabrielBinottiActiveRecord\interfaces\InterfaceActiveRecord;

class Insert extends Builder
{

    private $table;

    private function __construct()
    {
    }

    public static function into($table)
    {
        $self = new self;
        $self->table = $table;

        return $self;
    }

    private function createQuery()
    {
        if (!$this->table) {
            throw new Exception('You need to call the method into() before.');
        }

        if (!$this->binds) {
            throw new Exception('The query need the data to insert');
        }

        $query = "INSERT INTO {$this->table}(";
        $query .= implode(',', array_keys($this->binds)) . ') VALUES(';
        $query .= ':' . implode(',:', array_keys($this->binds)) . ')';

        return $query;
    }

    public function insert(InterfaceActiveRecord $interface, $data)
    {
        $this->binds = $data;
        $query = $this->createQuery();

        try {
            $result = $this->execute($query, $interface);

            return $result;
        } catch (Exception $e) {
            echo "Erro: $e";
        }
    }
}
