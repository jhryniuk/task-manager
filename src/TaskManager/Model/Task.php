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
     * @param null $id
     * @param null $name
     * @param null $description
     * @param string $priority
     */
    public function __construct(
        $id = null,
        $name = null,
        $description = null,
        $priority = 'medium'
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

    /**
     * @return int
     */
    public function getId() :int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName() :string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription() :string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getPriority(): string
    {
        return $this->priority;
    }

    /**
     * @param string $priority
     */
    public function setPriority(string $priority)
    {
        $this->priority = $priority;
    }
}
