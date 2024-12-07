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
}
