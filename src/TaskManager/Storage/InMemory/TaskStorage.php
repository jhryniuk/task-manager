<?php

namespace TaskManager\Storage\InMemory;

use TaskManager\Storage\Storage;

class TaskStorage implements Storage
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var int
     */
    private $lastId = 0;

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function findAll(): array
    {
        if (empty($this->data)) {
            return [];
        }

        $tasks = [];
        foreach ($this->data as $key => $item) {
            $tasks[] = [
                'id' => (int) $key,
                'name' => (string) $item['name'],
                'description' => (string) $item['description'],
                'priority' => (string)$item['priority']
            ];
        }

        return $tasks;
    }

    public function find(int $id): ?array
    {
        if (!isset($this->data[$id])) {
            return null;
        }

        return [
            'id' => (int) $id,
            'name' => (string) $this->data[$id]['name'],
            'description' => (string) $this->data[$id]['description'],
            'priority' => (string)$this->data[$id]['priority']
        ];
    }

    public function findBy(string $name, string $value): array
    {
        if (empty($this->data)) {
            return [];
        }

        $tasks = [];
        foreach ($this->data as $id => $item) {
            if ($item[$name] != $value) {
                continue;
            }

            $tasks[] =  [
                'id' => (int)$id,
                'name' => (string) $this->data[$id]['name'],
                'description' => (string) $this->data[$id]['description'],
                'priority' => (string)$this->data[$id]['priority']
            ];
        }

        return $tasks;
    }

    public function persist(array $data): int
    {
        $this->lastId++;

        $data['id'] = $this->lastId;
        $this->data[$this->lastId] = $data;

        return $this->lastId;
    }
}
