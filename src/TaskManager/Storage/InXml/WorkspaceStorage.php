<?php

namespace TaskManager\Storage\InXml;

class WorkspaceStorage
{
    const PATH = 'data.xml';

    /**
     * @var array
     */
    private $data = [];

    public function __construct()
    {
        $this->data = simplexml_load_file(self::PATH);
    }

    public function findAll()
    {
        foreach ($this->data as $item) {
            $workspaces[] = [
                'id' => (int) $item->id,
                'name' => (string) $item->name,
                'description' => (string) $item->description
            ];
        }

        return empty($workspaces) ? [] : $workspaces;
    }

    /**
     * @param int $id
     *
     * @return array|null
     */
    public function find(int $id)
    {
        foreach ($this->data as $item) {
            if ((int) $item->id == $id) {

                return [
                    'id' => (int)$item->id,
                    'name' => (string)$item->name,
                    'description' => (string)$item->description
                ];
            }
        }

        return null;
    }

    public function persist(array $data): int
    {
        $id = $this->data->count() + 1;
        $workspaces = $this->data;
        $workspace = $workspaces->addChild('workspace');
        $workspace->addChild('id', $id);
        $workspace->addChild('name', $data['name']);
        $workspace->addChild('description', $data['description']);
        $this->data->saveXML(self::PATH);

        return $id;
    }
}