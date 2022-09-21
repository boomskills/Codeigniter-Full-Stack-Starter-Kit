<?php

namespace App\Libraries;

use Exception;

class UniqueID
{
    public static function generate($configArr)
    {
        $db = db_connect();

        if (!array_key_exists('table', $configArr) || '' == $configArr['table']) {
            throw new Exception('Must need a table name');
        }
        if (!array_key_exists('length', $configArr) || '' == $configArr['length']) {
            throw new Exception('Must specify the length of ID');
        }
        if (!array_key_exists('prefix', $configArr) || '' == $configArr['prefix']) {
            throw new Exception('Must specify a prefix of your ID');
        }

        if (array_key_exists('where', $configArr)) {
            if (is_string($configArr['where'])) {
                throw new Exception('where clause must be an array, you provided string');
            }
            if (!count($configArr['where'])) {
                throw new Exception('where clause must need at least an array');
            }
        }

        $table = $configArr['table'];
        $field = array_key_exists('field', $configArr) ? $configArr['field'] : 'id';
        $prefix = $configArr['prefix'];
        $resetOnPrefixChange = array_key_exists('reset_on_prefix_change', $configArr) ? $configArr['reset_on_prefix_change'] : false;
        $length = $configArr['length'];

        $fieldInfo = (new self())->getFieldType($table, $field);
        $tableFieldType = $fieldInfo['type'];
        $tableFieldLength = $fieldInfo['length'];

        if (in_array($tableFieldType, ['int', 'integer', 'bigint', 'numeric']) && !is_numeric($prefix)) {
            throw new Exception("{$field} field type is {$tableFieldType} but prefix is string");
        }

        if ($length > $tableFieldLength) {
            throw new Exception('Generated ID length is bigger then table field length');
        }

        $prefixLength = strlen($configArr['prefix']);
        $idLength = $length - $prefixLength;
        $whereString = '';

        if (array_key_exists('where', $configArr)) {
            $whereString .= ' WHERE ';
            foreach ($configArr['where'] as $row) {
                $whereString .= $row[0] . '=' . $row[1] . ' AND ';
            }
        }
        $whereString = rtrim($whereString, 'AND ');

        $totalQuery = sprintf('SELECT count(%s) total FROM %s %s', $field, $configArr['table'], $whereString);
        $total = $db->query($totalQuery)->getResultObject();

        if ($total[0]->total) {
            if ($resetOnPrefixChange) {
                $maxQuery = sprintf('SELECT MAX(%s) AS maxid FROM %s WHERE %s LIKE %s', $field, $table, $field, "'" . $prefix . "%'");
            } else {
                $maxQuery = sprintf('SELECT MAX(%s) AS maxid FROM %s', $field, $table);
            }

            $queryResult = $db->query($maxQuery)->getResultObject();

            $maxFullId = $queryResult[0]->maxid;

            $maxId = substr($maxFullId, $prefixLength, $idLength);

            return $prefix . str_pad((int) $maxId + 1, $idLength, '0', STR_PAD_LEFT);
        }

        return $prefix . str_pad(1, $idLength, '0', STR_PAD_LEFT);
    }

    private function getFieldType($table, $field)
    {
        $db = db_connect();
        $driver = $db->getPlatform();
        $database = $db->getDatabase();

        if ('MySQLi' == $driver) {
            $sql = 'SELECT column_name AS "column_name",data_type AS "data_type",column_type AS "column_type" FROM INFORMATION_SCHEMA.COLUMNS';
            //$sql .= 'WHERE table_schema=:database AND table_name=:table';
        } else {
            // column_type not available in postgres SQL
            // table_catalog is database in postgres
            $sql = 'SELECT column_name AS "column_name",data_type AS "data_type" FROM INFORMATION_SCHEMA.COLUMNS';
            // $sql .= 'WHERE table_catalog=:database AND table_name=:table';
        }

        $rows = $db->query($sql, ['database' => $database, 'table' => $table])->getResult();
        $fieldType = null;
        $fieldLength = null;

        foreach ($rows as $col) {
            if ($field == $col->column_name) {
                $fieldType = $col->data_type;
                if ('mysql' == $driver) {
                    //example: column_type int(11) to 11
                    preg_match('/(?<=\\().+?(?=\\))/', $col->column_type, $tblFieldLength);
                    $fieldLength = $tblFieldLength[0];
                } else {
                    //column_type not available in postgres SQL
                    $fieldLength = 32;
                }

                break;
            }
        }

        if (null == $fieldType) {
            throw new Exception("{$field} not found in {$table} table");
        }

        return ['type' => $fieldType, 'length' => $fieldLength];
    }
}
