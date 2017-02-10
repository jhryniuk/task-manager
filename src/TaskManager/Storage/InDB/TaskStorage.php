<?php

namespace TaskManager\Storage\InDatabase;

use TaskManager\Storage\Storage;

class TaskStorage implements Storage
{
    /** @var  \PDO */
    private $db;

    public function __construct(\PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function findAll()
    {
        $results = $this->db->query('SELECT * FROM task');
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
        $result = $sth->execute();

        return [
            'id' => (int)$result['id'],
            'name' => (string)$result['name'],
            'description' => (string)$result['description'],
            'priority' => (string)$result['priority']
        ];
    }

    public function findBy(array $data)
    {

    }

    public function persist(array $data): int
    {
        $sth = $this->db->prepare('INSERT INTO task (name, description, priority) VALUES(:name, :description, :priority)');
        $sth->bindParams([
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':priority' => $data['priority']
        ]);

        $sth->execute();
    }
}