<?php

namespace TaskManager\Controller;

use ParameterBag;
use TaskManager\Model\Task;
use TaskManager\Repository\TaskRepository;
use TaskManager\Storage\StorageFactory;

class TaskController extends BaseController
{
    public function indexAction()
    {
        $storageFactory = new StorageFactory();
        $storage = $storageFactory->get(ParameterBag::get('storage'));
        $taskRepository = new TaskRepository($storage);
        $tasks = $taskRepository->getAll();

        $this->render('task/index.html.twig', ['tasks' => $tasks]);
    }

    public function showAction($params)
    {
        $storageFactory = new StorageFactory();
        $storage = $storageFactory->get(ParameterBag::get('storage'));
        $taskRepository = new TaskRepository($storage);
        $task = $taskRepository->getSingle($params[0]);

        $this->render('task/show.html.twig', ['task' => $task]);
    }

    public function createAction()
    {
        if (!isset($_POST['submit'])) {
            $this->render('task/create.html.twig');
        } else {
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $description = isset($_POST['description']) ? $_POST['description'] : '';
            $priority = isset($_POST['priority']) ? $_POST['priority'] : '';

            $task = new Task();
            $task->setName($name);
            $task->setDescription($description);
            $task->setPriority($priority);

            $storageFactory = new StorageFactory();
            $storage = $storageFactory->get(ParameterBag::get('storage'));
            $taskRepository = new TaskRepository($storage);
            $taskRepository->save($task);

            $this->indexAction();
        }
    }
}
