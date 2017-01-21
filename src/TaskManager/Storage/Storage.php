<?php

namespace TaskManager\Storage;

interface Storage
{
    public function findAll();

    public function find(int $id);

    public function persist(array $data);
}
