<?php

namespace App\Repositories;

use PDO;
use RuntimeException;

class Repository
{
    protected PDO $db;
    protected string $table;
    protected array $modelMap;

    public function __construct(PDO $db, string $table)
    {
        $this->db = $db;
        $this->table = $table;
    }

    public function findAll()
    {
        # define the query
        $stmt = $this->db->prepare("SELECT * FROM {$this->table};");
        # execute the statement
        $stmt->execute();
        # return the associative array or false
        return $stmt->fetch(PDO::FETCH_ASSOC) ?? false;
    }

    public function findById(int $id, string $label = 'id')
    {
        # define the query
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$label} = :id;");
        # bind the id parameter
        $stmt->bindParam('id', $id, PDO::PARAM_INT);
        # execute the statement
        $stmt->execute();
        # return the entity or false
        return $stmt->fetch(PDO::FETCH_ASSOC) ?? false;
    }

    # find an entity by single / multiple attributes
    public function find(array $params)
    {
        if (count($params) == 0) {
            throw new RuntimeException("Error in Model find() - no query parameters received");
        }

        # extract the parameters received
        $columns = array_keys($params);
        # compose the query with placeholders
        $queryParams = [];
        foreach ($params as $key => $val) $queryParams[] = "{$key} = :{$key}";
        $where = implode(' AND ', $queryParams);
        # prepare the query
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$where};");
        # execute the query
        $stmt->execute($params);
        # return the result
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    # update the entity calling the method
    public function save($model)
    {
        print_r($model);
        echo PHP_EOL . $model->email;
        die();
        # check table value
        if (!isset($this->table)) {
            throw new RuntimeException("Attribute TABLE must be defined.");
        }

        # extract instance attributes
        $attributes = get_object_vars($model);
        $columns = [];
        $values = [];

        foreach ($attributes as $key => $val) {

            # check if the property is set in the model map
            if (isset($this->modelMap[$key])) {
                # encode value if is an array
                if (is_array($val)) {
                    $val = json_encode($val);
                }
                # store the column name
                $columns[] = $this->modelMap[$key];
                # store the value for the column
                $values[] = isset($val) ? $val : null;
            }
        }

        # if the object that is to be persisted is empty - throw exception
        if (empty($columns)) {
            throw new RuntimeException("Element cannot be persisted in " . $this->table . " if it holds no values!");
        }

        # check if the entity is new or need to be updated
        if (!isset($model->id)) {
            # create the column list string
            $columnsStr = implode(',', $columns);
            # create the PDO placeholders for values
            $valuesPlaceholder = implode(',', array_fill(0, count($columns), '?'));
            # compose the query
            $query = "INSERT INTO {$this->table} ({$columnsStr}) VALUES ({$valuesPlaceholder});";
            echo $query;
            die();
        } else {
            # define the SET statement
            $updateParts = [];
            foreach ($columns as $col) $updateParts[] = "{$col} = ?";
            $update = implode(',', $updateParts);
            # compose the query
            $query = "UPDATE {$this->table} SET {$update} WHERE id = ?;";
            # add id to the values array
            $values[] = $model->id;
        }

        # prepare the query statement
        $stmt = $this->db->prepare($query);
        # execute the query
        $stmt->execute($values);
        # if INSERT INTO return id
        if (!isset($model->id)) {
            return intval($this->db->lastInsertId());
        }
    }
}
