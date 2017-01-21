<?php

namespace TaskManager\Controller;

use TaskManager\Repository\WorkspaceRepository;
use TaskManager\Storage\InXml\WorkspaceStorage;

class WorkspaceController
{
    public function indexAction()
    {
        $storage = new WorkspaceStorage();
        $workspaceRepository = new WorkspaceRepository($storage);
        $data = $workspaceRepository->getAll();

        var_dump($data);exit;
    }
}