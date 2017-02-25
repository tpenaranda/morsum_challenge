<?php

use Carbon\Carbon;

class OurLittleORM
{
    public function __call($methodName, $params)
    {
        $property = strtolower(preg_replace('/^[g,s]et/', '', $methodName));

        if (preg_match('/^get/', $methodName)) {
            return property_exists($this, $property) ? $this->$property : null;
        } elseif (preg_match('/^set/', $methodName) && in_array($property, $this->fillable)) {
            $this->$property = $params[0];

            return $this;
        } else {
            throw new Exception('Method name not supported.');
        }
    }

    public static function fetchAll()
    {
        global $dbConnection;

        $calledClass = get_called_class();

        $rows = $dbConnection->query("SELECT id FROM {$calledClass::$tableName}")->fetchAll();

        $output = [];
        foreach ($rows as $row) {
            $output[] = (new $calledClass())->getById($row['id']);
        }

        return $output;
    }

    public static function getById($id = 0)
    {
        $returnObject = null;

        if ($id = (int) $id) {
            $calledClass = get_called_class();
            global $dbConnection;
            $result = $dbConnection->query("SELECT * FROM {$calledClass::$tableName} WHERE id = $id LIMIT 1")->fetchAll()[0];

            if (!empty($result)) {
                $returnObject = new $calledClass();

                foreach (array_keys(get_object_vars($returnObject)) as $property) {
                    $returnObject->$property = $result[$property];
                }
            }
        }

        return $returnObject;
    }

    public static function validate(array $input = [])
    {
        $calledClass = get_called_class();

        return empty(array_diff($calledClass::$fillable, array_keys($input)));
    }

    public function save()
    {
        global $dbConnection;

        $columnsArray = $this::$fillable;
        $valuesArray = [];

        foreach ($this::$fillable as $column) {
            $valuesArray[] = "'{$this->$column}'";
        }

        if (empty($this->id)) {
            $columnsArray = $this::$fillable;
            $valuesArray = [];

            foreach ($this::$fillable as $column) {
                $valuesArray[] = "'{$this->$column}'";
            }

            $columns = implode(',', $columnsArray);
            $values = implode(',', $valuesArray);

            $sql = "INSERT INTO {$this::$tableName} ($columns) VALUES ($values)";

            $dbConnection->exec($sql);

            $this->id = $dbConnection->lastInsertId();
        } else {
            $valuesToSetArray = [];

            foreach ($columnsArray as $column) {
                $valuesToSetArray[] = "{$column} = '{$this->$column}'";
            }

            $valuesToSet = implode(',', $valuesToSetArray);

            $sql = "UPDATE {$this::$tableName} SET {$valuesToSet} WHERE id = {$this->id}";

            $dbConnection->exec($sql);
        }

        return $this->getById($this->id);
    }

    public static function create($input)
    {
        $calledClass = get_called_class();

        $model = new $calledClass($input);
        return $model->save();
    }

}
