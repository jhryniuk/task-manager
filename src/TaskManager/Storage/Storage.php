<?php

namespace TaskManager\Storage;

interface Storage
{
    public function findAll();

    public function find(int $id);

    public function findBy(string $name, string $value);

    public function persist(array $data);
}
