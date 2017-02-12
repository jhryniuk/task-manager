<?php

namespace TaskManager\Controller;

use Controller;
use TaskManager\Model\Task;
use TaskManager\Repository\TaskRepository;
use TaskManager\Storage\Storage;

class TaskController extends Controller
{
    public function indexAction()
    {
        /** @var Storage $storage */
        $storage = $this->get('task_storage_in_xml');
        $taskRepository = new TaskRepository($storage);
        $tasks = $taskRepository->getAll();

        return $this->render('task/index.html.twig', ['tasks' => $tasks]);
    }

    public function showByPriorityAction($params)
    {
        /** @var Storage $storage */
        $storage = $this->get('task_storage_in_xml');
        $taskRepository = new TaskRepository($storage);
        $tasks = $taskRepository->getBy('priority', $params[0]);

        return $this->render('task/index.html.twig', ['tasks' => $tasks]);
    }

    public function showAction($params)
    {
        /** @var Storage $storage */
        $storage = $this->get('task_storage_in_xml');
        $taskRepository = new TaskRepository($storage);
        $task = $taskRepository->getSingle($params[0]);

        return $this->render('task/show.html.twig', ['task' => $task]);
    }

    public function createAction()
    {
        if (!isset($_POST['submit'])) {
            return $this->render('task/create.html.twig');
        } else {
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $description = isset($_POST['description']) ? $_POST['description'] : '';
            $priority = isset($_POST['priority']) ? $_POST['priority'] : '';

            $task = new Task();
            $task->setName($name);
            $task->setDescription($description);
            $task->setPriority($priority);

            /** @var Storage $storage */
            $storage = $this->get('task_storage_in_xml');
            $taskRepository = new TaskRepository($storage);
            $taskRepository->save($task);

            return $this->indexAction();
        }
    }
}
