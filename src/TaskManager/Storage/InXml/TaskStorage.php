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

    public function findAll(): array
    {
        if (empty($this->data)) {
            return [];
        }

        $tasks = [];
        foreach ($this->data as $item) {
            $tasks[] = [
                'id' => (int) $item->id,
                'name' => (string) $item->name,
                'description' => (string) $item->description,
                'priority' => (string)$item->priority
            ];
        }

        return $tasks;
    }

    public function find(int $id): ?array
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

    public function findBy(string $name, string $value): array
    {
        if (empty($this->data)) {
            return [];
        }

        $tasks = [];
        foreach ($this->data as $item) {
            if ($item->$name != $value) {
                continue;
            }

            $tasks[] = [
                'id' => (int)$item->id,
                'name' => (string)$item->name,
                'description' => (string)$item->description,
                'priority' => (string)$item->priority
            ];
        }

        return $tasks;
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
