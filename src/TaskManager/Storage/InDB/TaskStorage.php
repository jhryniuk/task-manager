<?php

namespace TaskManager\Storage\InDB;

use PDO;
use TaskManager\Storage\Storage;

class TaskStorage implements Storage
{
    /** @var PDO */
    private $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function findAll()
    {
        $sth = $this->db->prepare('SELECT * FROM task');
        $sth->execute();
        $results = $sth->fetchAll();

        foreach ($results as $item) {
            $tasks[] = [
                'id' => (int) $item['id'],
                'name' => (string) $item['name'],
                'description' => (string) $item['description'],
                'priority' => (string)$item['priority']
            ];
        }

        return empty($tasks) ? [] : $tasks;
    }

    /**
     * @param int $id
     *
     * @return array|null
     */
    public function find(int $id)
    {
        $sth = $this->db->prepare('SELECT * FROM task WHERE id = :id');
        $sth->bindParam(':id', $id);
        $sth->execute();
        $result = $sth->fetch();

        return [
            'id' => (int)$result['id'],
            'name' => (string)$result['name'],
            'description' => (string)$result['description'],
            'priority' => (string)$result['priority']
        ];
    }

    public function findBy(string $name, string $value)
    {
        $sth = $this->db->prepare('SELECT * FROM task WHERE '.$name.' = :value');
        $sth->bindParam(':value', $value);
        $sth->execute();
        $results = $sth->fetchAll();

        foreach ($results as $item) {
            $tasks[] = [
                'id' => (int) $item['id'],
                'name' => (string) $item['name'],
                'description' => (string) $item['description'],
                'priority' => (string)$item['priority']
            ];
        }

        return empty($tasks) ? [] : $tasks;
    }

    public function persist(array $data): int
    {
        $sth = $this
            ->db->prepare('INSERT INTO task (name, description, priority) VALUES(:name, :description, :priority)');
        $sth->bindParam(':name', $data['name']);
        $sth->bindParam(':description', $data['description']);
        $sth->bindParam(':priority', $data['priority']);

        $sth->execute();

        return $this->db->lastInsertId();
    }
}
