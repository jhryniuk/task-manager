<?php

namespace spec\TaskManager\Repository;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TaskManager\Model\Task;
use TaskManager\Storage\InMemory\TaskStorage;

class TaskRepositorySpec extends ObjectBehavior
{
    public function let(TaskStorage $storage)
    {
        $this->beConstructedWith($storage);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('TaskManager\Repository\TaskRepository');
    }

    function it_should_return_all_task(TaskStorage $storage)
    {
        $data = [[
                    'id' => 1,
                    'name' => 'Work',
                    'description' => 'Tasks to do in work',
                    'priority' => 'low'
                ]];
        $storage->findAll()->willReturn($data);
        $this->beConstructedWith($storage);

        $result = $this->getAll();
        $first = $result[0];

        $result->shouldBeArray();
        $result->shouldHaveCount(1);
        $first->shouldHaveType(Task::class);
    }

    function it_should_return_task(TaskStorage $storage)
    {
        $data = [
            'id' => 1,
            'name' => 'Work',
            'description' => 'Tasks to do in work',
            'priority' => 'low'
        ];
        $storage->find(1)->willReturn($data);
        $this->beConstructedWith($storage);

        $result = $this->getSingle(1);

        $result->shouldHaveType(Task::class);
    }

    function it_should_throw_exception(TaskStorage $storage)
    {
        $storage->find(25)->willReturn(null);
        $this->beConstructedWith($storage);

        $this->shouldThrow(\InvalidArgumentException::class)->during('getSingle',[25]);
    }

    function it_should_save_task(TaskStorage $storage, Task $task)
    {
        $data = [
            'name' => 'Work',
            'description' => 'Tasks to do in work',
            'priority' => 'low'
        ];
        $task->setId(1)->willReturn();
        $task->getName()->willReturn('Work');
        $task->getDescription()->willReturn('Tasks to do in work');
        $task->getPriority()->willReturn('low');
        $storage->persist($data)->willReturn(1);

        $this->save($task);

        $task->setId(1)->shouldBeCalled();
    }
}
