<?php

namespace TaskManager\Controller;

use TaskManager\Repository\WorkspaceRepository;
use TaskManager\Storage\StorageFactory;

class WorkspaceController
{
    public function indexAction()
    {
        $storageFactory = new StorageFactory();
        $storage = $storageFactory->get('xml');
        $workspaceRepository = new WorkspaceRepository($storage);
        $data = $workspaceRepository->getAll();

        var_dump($data);exit;
    }
}