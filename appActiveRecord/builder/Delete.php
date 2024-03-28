<?php

namespace GabrielBinottiActiveRecord\builder;

use Exception;
use GabrielBinottiActiveRecord\interfaces\InterfaceActiveRecord;

class Delete extends Builder
{
    private $table;

    private function __construct()
    {
        
    }

    public static function table($table)
    {
        $self = new self;
        $self->table = $table;

        return $self;
    }

    public function createQuery()
    {
        if(!$this->table){
            throw new Exception("You need to call the method table() before.");
        }

        $query = "DELETE FROM {$this->table} ";
        $query .= ($this->where) ? "WHERE " . implode('', $this->where) : '';

        return $query;
    }

    public function delete(InterfaceActiveRecord $interface)
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