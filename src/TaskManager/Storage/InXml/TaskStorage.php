<?php

namespace TaskManager\Storage\InXml;

use TaskManager\Storage\Storage;

class TaskStorage implements Storage
{
    /** @var string */
    private $filePath;

    private $data;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $this->data = simplexml_load_file($this->filePath);
    }

    public function findAll()
    {
        foreach ($this->data as $item) {
            $tasks[] = [
                'id' => (int) $item->id,
                'name' => (string) $item->name,
                'description' => (string) $item->description,
                'priority' => (string)$item->priority
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
            if ((int) $item->id != $id) {
                continue;
            }

            return [
                'id' => (int)$item->id,
                'name' => (string)$item->name,
                'description' => (string)$item->description,
                'priority' => (string)$item->priority
            ];
        }

        return null;
    }

    /**
     * @param array $array
     * @return array|null
     */
    public function findBy(array $array)
    {
        foreach ($array as $key => $value) {
            foreach ($this->data as $item) {
                if ($item->$key != $value) {
                    continue;
                }

                $tasks[] =  [
                    'id' => (int)$item->id,
                    'name' => (string)$item->name,
                    'description' => (string)$item->description,
                    'priority' => (string)$item->priority
                ];
            }
        }

        return empty($tasks) ? [] : $tasks;
    }

    public function persist(array $data): int
    {
        $id = $this->data->count() + 1;
        $tasks = $this->data;
        $task = $tasks->addChild('task');
        $task->addChild('id', $id);
        $task->addChild('name', $data['name']);
        $task->addChild('description', $data['description']);
        $task->addChild('priority', $data['priority']);
        $this->data->saveXML($this->filePath);

        return $id;
    }
}
