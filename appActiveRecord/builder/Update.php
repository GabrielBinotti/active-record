<?php

namespace GabrielBinottiActiveRecord\builder;

use Exception;
use GabrielBinottiActiveRecord\interfaces\InterfaceActiveRecord;

class Update extends Builder
{
    private $table;
    private $data = [];

    private function __construct()
    {
        
    }

    public static function table($table)
    {
        $self = new self;
        $self->table = $table;

        return $self;
    }

    public function set($data)
    {
        $this->data = $data;

        return $this;
    }

    private function createQuery()
    {
        if (!$this->table) {
            throw new Exception('You need to call the method table() before.');
        }

        if (!$this->data) {
            throw new Exception('You need to send data to change using method set().');
        }

        $query = "UPDATE {$this->table} SET ";
        foreach ($this->data as $field => $value) {
            $query .= "{$field} = :{$field},";
            $this->binds[$field] = $value;
        }

        $query = rtrim($query, ',');
        $query .= !empty($this->where) ? ' WHERE ' . implode(' ', $this->where) : '';

        return $query;
    }


    public function update(InterfaceActiveRecord $interface)
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