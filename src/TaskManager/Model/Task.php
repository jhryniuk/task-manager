<?php

namespace TaskManager\Model;

class Task
{
    /** @var integer */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $description;

    /** @var string */
    private $priority;

    /**
     * Task constructor.
     * @param int $id
     * @param string $name
     * @param string $description
     * @param string $priority
     */
    public function __construct(
        int $id = 0,
        string $name = '',
        string $description = '',
        string $priority = 'medium'
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->priority = $priority;
    }

    public static function fromState(array $state): Task
    {
        return new self(
            $state['id'],
            $state['name'],
            $state['description'],
            $state['priority']
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function getPriority() : ?string
    {
        return $this->priority;
    }

    public function setPriority(string $priority)
    {
        $this->priority = $priority;
    }
}
