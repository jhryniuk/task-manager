<?php

return  [
  '/' => [
      'module'      => 'TaskManager',
      'controller'  => 'Task',
      'action'      => 'index'
  ],
  '/tasks' => [
      'module'      => 'TaskManager',
      'controller'  => 'Task',
      'action'      => 'index'
  ],
  '/tasks/(\d+)' => [
      'module'      => 'TaskManager',
      'controller'  => 'Task',
      'action'      => 'show'
  ],
  '/tasks/new' => [
      'module'      => 'TaskManager',
      'controller'  => 'Task',
      'action'      => 'create'
    ]
];