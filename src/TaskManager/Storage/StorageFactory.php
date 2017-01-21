<?php

namespace TaskManager\Storage;

use TaskManager\Storage\InMemory\TaskStorage as InMemoryTaskStorage;
use TaskManager\Storage\InXml\TaskStorage as InXmlTaskStorage;

class StorageFactory
{
    const IN_MEMORY = 'memory';
    const IN_XML = 'xml';

    public function get($method)
    {
        switch ($method) {
            case self::IN_MEMORY:
                return new InMemoryTaskStorage();
                break;
            case self::IN_XML:
                return new InXmlTaskStorage();
                break;
            default:
                return new InMemoryTaskStorage();
        }
    }
}
