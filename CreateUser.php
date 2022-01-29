<?php
require_once __DIR__ . '/config.php';
print_r($keycloakObj->createUser('test1', 'Rahul', 'Sharma', 'test1@test.com', [
  [
      'type'=>'password',
      'value'=>'1234',
  ],
]));
?>