<?php

namespace TaskManager\Controller;

use TaskManager\Repository\WorkspaceRepository;
use TaskManager\Storage\StorageFactory;

class WorkspaceController extends BaseController
{
    public function indexAction()
    {
        $storageFactory = new StorageFactory();
        $storage = $storageFactory->get('xml');
        $workspaceRepository = new WorkspaceRepository($storage);
        $workspaces = $workspaceRepository->getAll();

        $this->render('workspace/index.html.twig', ['workspaces' => $workspaces]);
    }
}