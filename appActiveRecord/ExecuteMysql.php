<?php

namespace GabrielBinottiActiveRecord;

use Exception;
use GabrielBinottiActiveRecord\interfaces\InterfaceActiveRecord;

class ExecuteMysql implements InterfaceActiveRecord
{
    public function execute($query, $binds, $method)
    {
        try {

            $pdo = Connection::getConnection();
            Connection::beginTransaction();

            $stmt = $pdo->prepare($query);

            switch ($method) {
                case 'find':
                    $stmt->execute($binds ?? []);
                    $result = $stmt->fetch();
                    break;
                case 'findAll':
                    $stmt->execute($binds ?? []);
                    $result = $stmt->fetch();
                    break;
                case 'delete':
                    $stmt->execute($binds ?? []);
                    $result = $stmt->rowCount();
                    break;
                case 'update':
                    $stmt->execute($binds ?? []);
                    $result = $stmt->rowCount();
                    break;

                case 'insert':
                    $stmt->execute($binds ?? []);
                    $result = $stmt->rowCount();
                    break;

                default:
                    throw new Exception("Error in method");
                    break;
            }


            Connection::close();
            return $result;
        } catch (Exception $e) {
            Connection::rollback();
            echo $e->getMessage();
        }
    }
}
