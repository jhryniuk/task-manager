<?php

namespace TaskManager\Storage\InXml;

use TaskManager\Storage\Storage;
use ParameterBag;

class TaskStorage implements Storage
{
    const PATH = 'data.xml';

    /**
     * @var array
     */
    private $data = [];

    public function __construct()
    {
        $this->data = simplexml_load_file(ParameterBag::get('xml_location'));
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

    public function persist(array $data): int
    {
        $id = $this->data->count() + 1;
        $tasks = $this->data;
        $task = $tasks->addChild('task');
        $task->addChild('id', $id);
        $task->addChild('name', $data['name']);
        $task->addChild('description', $data['description']);
        $task->addChild('priority', $data['priority']);
        $this->data->saveXML(ParameterBag::get('xml_location'));

        return $id;
    }
}
