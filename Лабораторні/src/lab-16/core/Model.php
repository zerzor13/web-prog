<?php
class Model
{
    protected $pdo = null;
    protected $table = null;

    public $columns = null;
    public function __construct(PDO $pdo, $table = null, $data = null)
    {
        $this->pdo = $pdo;
        $this->columns = (object)[];
        if (!$this->table) $this->table = $table;

        $sql = "SHOW COLUMNS FROM $this->table";
        $stmt = $pdo->query($sql);

        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($columns as $column) {
            $fn = $column['Field'];
            $this->columns->$fn = null;
        }
        if ($data) {
            foreach ($data as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function all()
    {
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->pdo->prepare($sql);
        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $models = [];
        foreach ($rows as $row) {
            $model = new Model($this->pdo, $this->table);
            foreach ($row as $key => $value) {
                $model->columns->$key = $value;
            }
            $models[] = $model;
        }
        return $models;
    }

    public function find($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            //$model = new Model($this->pdo, $this->table);
            foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $key => $value) {
                $this->columns->$key = $value;
            }
            return $this;
        }
        return null;
    }

    public function insert($data, $table = null)
    {
        $columns = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO $this->table ($columns) VALUES ($values)";
        $stmt = $this->pdo->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        return $stmt->execute();
    }

    public function update($id, $data)
    {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = :$key";
        }
        $set = implode(', ', $set);

        $sql = "UPDATE $this->table SET $set WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':id', $id);
        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
