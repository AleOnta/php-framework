<?php

namespace App\Core;

use PDO;
use RuntimeException;
use App\Core\MySQL;

class Model
{
    protected PDO $db;
    protected ?int $id = null;
    protected array $modelMap;
    protected string $table;

    public function __construct()
    {
        # establish mysql connection
        $this->db = MySQL::getInstance()->getConnection();
    }

    # find an entity by id in the corresponding table
    public function findById(int $id)
    {
        # prepare the query
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1;");
        $stmt->bindValue('id', $id, PDO::PARAM_INT);
        $stmt->execute();
        # return the result of the query
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    # find an entity by single / multiple attributes
    public function find(array $params)
    {
        if (count($params) == 0) {
            throw new RuntimeException("Error in Model find() - no query parameters received");
        }

        # extract the parameters received
        $columns = array_keys($params);

        # check if the column searched exists on the table
        foreach ($columns as $column) {
            if (!in_array($column, array_values($this->modelMap))) {
                throw new RuntimeException("Column ({$column}) does not exists on '{$this->table}' table...");
            }
        }

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

    # create or update the entity calling the method
    public function save()
    {
        # check table value
        if (!isset($table)) {
            throw new RuntimeException("Attribute TABLE must be defined.");
        }

        # extract instance attributes
        $attributes = get_object_vars($this);
        $columns = [];
        $values = [];

        foreach ($attributes as $key => $val) {
            # skip model table mappings
            if ($key === 'modelMap') continue;

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
            throw new RuntimeException("Element cannot be persisted in " . static::$table . " if it holds no values!");
        }

        # check if the entity is new or need to be updated
        if ($this->id === null) {
            # create the column list string
            $columnsStr = implode(',', $columns);
            # create the PDO placeholders for values
            $valuesPlaceholder = implode(',', array_fill(0, count($columns), '?'));
            # compose the query
            $query = "INSERT INTO {$this->table} ({$columnsStr}) VALUES ({$valuesPlaceholder});";
        } else {
            # define the SET statement
            $updateParts = [];
            foreach ($columns as $col) $updateParts[] = "{$col} = ?";
            $update = implode(',', $updateParts);
            # compose the query
            $query = "UPDATE {$this->table} SET {$update} WHERE id = ?;";
            # add id to the values array
            $values[] = $this->id;
        }

        # prepare the query statement
        $stmt = $this->db->prepare($query);
        # execute the query
        $stmt->execute($values);
        # if INSERT INTO return id
        if ($this->id === null) {
            $this->id = (int)$this->db->lastInsertId();
            return $this->id;
        }
    }
}
