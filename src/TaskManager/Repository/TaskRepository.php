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

    public function getSingle(int $id) :Task
    {
        $task = $this->persistence->find($id);

        if (is_null($task)) {
            throw new \InvalidArgumentException(sprintf('Task with ID %d does not exist', $id));
        }

        return Task::fromState($task);
    }

    /**
     * @param string $name
     * @param string $value
     * @return Task[]|array
     */
    public function getBy(string $name, string $value)
    {
        $arrayData = $this->persistence->findBy($name, $value);
        foreach ($arrayData as $item) {
            $tasks[] = Task::fromState($item);
        }

        return empty($tasks) ? [] : $tasks;
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
