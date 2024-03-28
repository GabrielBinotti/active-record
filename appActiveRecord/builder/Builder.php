<?php

namespace GabrielBinottiActiveRecord\builder;

use GabrielBinottiActiveRecord\interfaces\InterfaceActiveRecord;

abstract class Builder
{

    protected $where = [];
    protected $binds = [];

    public function where($field, $operator, $value, $logic = null)
    {

        $placeholder = $field;

        if (strpos($placeholder, '.')) {
            $placeholder = str_replace('.', '', $placeholder);
        }

        $this->where[] = "{$field} {$operator} :{$placeholder} {$logic}";
        $this->binds[$placeholder] = strip_tags($value);


        return $this;
    }

    protected function execute($query, InterfaceActiveRecord $obj)
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
        $method = $backtrace[1]['function'];
        
        return $obj->execute($query, $this->binds, $method);
    }
}
