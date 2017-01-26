<?php

namespace TaskManager\Repository;

use TaskManager\Model\Task;
use TaskManager\Storage\Storage;

class TaskRepository
{
    /** @var Storage */
    private $persistence;

    public function __construct(Storage $persistence)
    {
        $this->persistence = $persistence;
    }

    /**
     * @return Task[]
     */
    public function getAll()
    {
        $arrayData = $this->persistence->findAll();
        foreach ($arrayData as $item) {
            $tasks[] = Task::fromState($item);
        }

        return empty($tasks) ? [] : $tasks;
    }

    /**
     * @param int $id
     * @return Task
     */
    public function getSingle(int $id) :Task
    {
        $arrayData = $this->persistence->find($id);

        if (is_null($arrayData)) {
            throw new \InvalidArgumentException(sprintf('Task with ID %d does not exist', $id));
        }

        return Task::fromState($arrayData);
    }

    /**
     * @param Task $task
     */
    public function save(Task $task)
    {
        $id = $this->persistence->persist([
            'name' => $task->getName(),
            'description' => $task->getDescription(),
            'priority' => $task->getPriority(),
        ]);

        $task->setId($id);
    }
}
