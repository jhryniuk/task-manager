<?php

namespace TaskManager\Repository;

use TaskManager\Model\Workspace;
use TaskManager\Storage\InXml\WorkspaceStorage;

class WorkspaceRepository
{
    private $persistence;

    public function __construct(WorkspaceStorage $persistence)
    {
        $this->persistence = $persistence;
    }

    /**
     * @return Workspace[]
     */
    public function getAll()
    {
        $arrayData = $this->persistence->findAll();
        foreach ($arrayData as $item) {
            $workspaces[] = Workspace::fromState($item);
        }

        return empty($workspaces) ? [] : $workspaces;
    }

    /**
     * @param int $id
     * @return Workspace
     */
    public function getSingle(int $id) :Workspace
    {
        $arrayData = $this->persistence->find($id);

        if (is_null($arrayData)) {
            throw new \InvalidArgumentException(sprintf('Workspace with ID %d does not exist', $id));
        }

        return Workspace::fromState($arrayData);
    }

    /**
     * @param Workspace $workspace
     */
    public function save(Workspace $workspace)
    {
        $id = $this->persistence->persist([
            'name' => $workspace->getName(),
            'description' => $workspace->getDescription(),
        ]);

        $workspace->setId($id);
    }
}