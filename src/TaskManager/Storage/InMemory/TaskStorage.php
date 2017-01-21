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

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->data;
    }

    /**
     * @param int $id
     *
     * @return array|null
     */
    public function find(int $id)
    {
        return isset($this->data[$id]) ? $this->data[$id] : null;
    }

    /**
     * @param array $data
     * @return int
     */
    public function persist(array $data): int
    {
        $this->lastId++;

        $data['id'] = $this->lastId;
        $this->data[$this->lastId] = $data;

        return $this->lastId;
    }
}
