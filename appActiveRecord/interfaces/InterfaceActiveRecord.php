<?php
namespace GabrielBinottiActiveRecord\interfaces;

interface InterfaceActiveRecord
{
    public function execute($query, $binds, $method);
}