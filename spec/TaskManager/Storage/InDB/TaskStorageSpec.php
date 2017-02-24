<?php

namespace spec\TaskManager\Storage\InDB;

use PDO;
use PDOStatement;
use PhpSpec\ObjectBehavior;

class TaskStorageSpec extends ObjectBehavior
{
    function let(PDO $pdo)
    {

        $this->beConstructedWith($pdo);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('TaskManager\Storage\InDB\TaskStorage');
    }

    function it_should_return_all_task(PDO $pdo, PDOStatement $PDOStatement)
    {
        $results = [
            [
                'id' => 1,
                'name' => 'Work',
                'description' => 'Tasks to do in work',
                'priority' => 'low'
            ],
            [
                'id' => 2,
                'name' => 'School',
                'description' => 'Tasks to do in school',
                'priority' => 'medium'
            ],
            [
                'id' => 3,
                'name' => 'Home',
                'description' => 'Tasks to do in home',
                'priority' => 'high'
            ]
        ];
        $PDOStatement->execute()->willReturn(true);
        $PDOStatement->fetchAll()->willReturn($results);
        $pdo->prepare('SELECT * FROM task')->willReturn($PDOStatement);
        $this->beConstructedWith($pdo);

        $result = $this->findAll();

        $result->shouldBeArray();
        $result->shouldHaveCount(3);
    }

    function it_should_return_task(PDO $pdo, PDOStatement $PDOStatement)
    {
        $results = [
                'id' => 1,
                'name' => 'Work',
                'description' => 'Tasks to do in work',
                'priority' => 'low'
        ];
        $id = 1;
        $PDOStatement->execute()->willReturn(true);
        $PDOStatement->bindParam(':id', $id)->willReturn(true);
        $PDOStatement->fetch()->willReturn($results);
        $pdo->prepare('SELECT * FROM task WHERE id = :id')->willReturn($PDOStatement);
        $this->beConstructedWith($pdo);


        $result = $this->find($id);

        $result->shouldBeArray();
        $result->shouldHaveCount(4);
        $result->shouldHaveKeyWithValue('id', 1);
        $result->shouldHaveKeyWithValue('name', 'Work');
        $result->shouldHaveKeyWithValue('description', 'Tasks to do in work');
        $result->shouldHaveKeyWithValue('priority', 'low');
    }

    function it_should_find_by_name(PDO $pdo, PDOStatement $PDOStatement)
    {
        $results = [[
            'id' => 1,
            'name' => 'Work',
            'description' => 'Tasks to do in work',
            'priority' => 'low'
        ]];
        $name = 'name';
        $value = 'Work';

        $PDOStatement->execute()->willReturn(true);
        $PDOStatement->bindParam(':value', $value)->willReturn(true);
        $PDOStatement->fetchAll()->willReturn($results);
        $pdo->prepare('SELECT * FROM task WHERE '.$name.' = :value')->willReturn($PDOStatement);
        $this->beConstructedWith($pdo);


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

    function it_should_persist(PDO $pdo, PDOStatement $PDOStatement)
    {
        $data = [
            'name' => 'Home',
            'description' => 'Tasks to do in home',
            'priority' => 'high'
        ];

        $PDOStatement->execute()->willReturn(true);
        $PDOStatement->bindParam(':name', $data['name'])->willReturn(true);
        $PDOStatement->bindParam(':description', $data['description'])->willReturn(true);
        $PDOStatement->bindParam(':priority', $data['priority'])->willReturn(true);

        $pdo->prepare('INSERT INTO task (name, description, priority) VALUES(:name, :description, :priority)')->willReturn($PDOStatement);
        $pdo->lastInsertId()->willReturn(4);
        $this->beConstructedWith($pdo);

        $result = $this->persist($data);
        $result->shouldBe(4);
    }
}
