<?php

namespace TaskManager\Controller;

use TaskManager\Repository\TaskRepository;
use TaskManager\Storage\StorageFactory;

class TaskController extends BaseController
{
    public function indexAction()
    {
        $storageFactory = new StorageFactory();
        $storage = $storageFactory->get('xml');
        $taskRepository = new TaskRepository($storage);
        $tasks = $taskRepository->getAll();

        $this->render('task/index.html.twig', ['tasks' => $tasks]);
    }
}
