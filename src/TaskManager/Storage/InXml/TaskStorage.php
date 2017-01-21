<?php

namespace TaskManager\Storage\InXml;

use TaskManager\Storage\Storage;

class TaskStorage implements Storage
{
    const PATH = 'data.xml';

    /**
     * @var array
     */
    private $data = [];

    public function __construct()
    {
        $this->data = simplexml_load_file(self::PATH);
    }

    public function findAll()
    {
        foreach ($this->data as $item) {
            $tasks[] = [
                'id' => (int) $item->id,
                'name' => (string) $item->name,
                'description' => (string) $item->description
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
        foreach ($this->data as $item) {
            if ((int) $item->id == $id) {
                return [
                    'id' => (int)$item->id,
                    'name' => (string)$item->name,
                    'description' => (string)$item->description
                ];
            }
        }

        return null;
    }

    public function persist(array $data): int
    {
        $id = $this->data->count() + 1;
        $tasks = $this->data;
        $task = $tasks->addChild('task');
        $task->addChild('id', $id);
        $task->addChild('name', $data['name']);
        $task->addChild('description', $data['description']);
        $this->data->saveXML(self::PATH);

        return $id;
    }
}
