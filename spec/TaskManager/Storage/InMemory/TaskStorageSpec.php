<?php

namespace spec\TaskManager\Storage\InMemory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TaskStorageSpec extends ObjectBehavior
{
    function let()
    {
        $data = [
            1 => [
                'name' => 'Work',
                'description' => 'Tasks to do in work',
                'priority' => 'low'
            ],
            2 => [
                'name' => 'School',
                'description' => 'Tasks to do in school',
                'priority' => 'medium'
            ],
            3 => [
                'name' => 'Home',
                'description' => 'Tasks to do in home',
                'priority' => 'high'
            ]
        ];
        $this->beConstructedWith($data);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('TaskManager\Storage\InMemory\TaskStorage');
    }

    function it_should_return_all_task()
    {
        $result = $this->findAll();

        $result->shouldBeArray();
        $result->shouldHaveCount(3);
    }

    function it_should_return_task()
    {
        $result = $this->find(1);

        $result->shouldBeArray();
        $result->shouldHaveCount(4);
        $result->shouldHaveKeyWithValue('id', 1);
        $result->shouldHaveKeyWithValue('name', 'Work');
        $result->shouldHaveKeyWithValue('description', 'Tasks to do in work');
        $result->shouldHaveKeyWithValue('priority', 'low');
    }

    function it_should_find_by_name()
    {
        $result = $this->findBy('name', 'Work');
        $firstItem = $result[0];

        $result->shouldBeArray();
        $result->shouldHaveCount(1);
        $firstItem->shouldHaveCount(4);
        $firstItem->shouldHaveKeyWithValue('id', 1);
        $firstItem->shouldHaveKeyWithValue('name', 'Work');
        $firstItem->shouldHaveKeyWithValue('description', 'Tasks to do in work');
        $firstItem->shouldHaveKeyWithValue('priority', 'low');
    }

    function it_should_persist()
    {
        $data = [
            'name' => 'Home',
            'description' => 'Tasks to do in home',
            'priority' => 'high'
        ];

        $result = $this->persist($data);
        $result->shouldBe(4);
    }
}
