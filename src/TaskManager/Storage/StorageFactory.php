<?php

namespace TaskManager\Storage;

use TaskManager\Storage\InMemory\WorkspaceStorage as InMemoryWorkspaceStorage;
use TaskManager\Storage\InXml\WorkspaceStorage as InXmlWorkspaceStorage;

class StorageFactory
{
    const IN_MEMORY = 'memory';
    const IN_XML = 'xml';

    public function get($method)
    {
        switch ($method) {
            case self::IN_MEMORY:
                return new InMemoryWorkspaceStorage();
                break;
            case self::IN_XML:
                return new InXmlWorkspaceStorage();
                break;
            default:
                return new InMemoryWorkspaceStorage();
        }
    }
}