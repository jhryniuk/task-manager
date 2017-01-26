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
        $this->data = [[
            'name' => 'School',
            'description' => 'Tasks to do in school',
            'priority' => 'high'
        ]];
    }

    /**
     * @return array
     */
    public function findAll()
    {
        foreach ($this->data as $key => $item) {
            $tasks[] = [
                'id' => (int) $key,
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

    /**
     * @param array $array
     * @return array|null
     */
    public function findBy(array $array)
    {
        foreach ($array as $key => $value) {
            foreach ($this->data as $id => $item) {
                if ($item[$key] != $value) {
                    continue;
                }

                $tasks[] =  [
                    'id' => (int)$id,
                    'name' => (string) $this->data[$id]['name'],
                    'description' => (string) $this->data[$id]['description'],
                    'priority' => (string)$this->data[$id]['priority']
                ];
            }
        }

        return empty($tasks) ? [] : $tasks;
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
