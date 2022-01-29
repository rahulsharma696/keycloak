<?php
require_once __DIR__ . '/config.php';
$user = [
  'id' => 'fa7032e1-3118-412e-9ab1-a2ea79f60517',
  'firstName' => 'Test 1',
  'lastName' => 'Test 2',
  'email' => 'modifytest12@test.com',
  'enabled' => true,
  'emailVerified' => true,
  'credentials' => [
      [
          'type'=>'password',
          'value'=>'1234',
      ],
  ],
];
print_r($keycloakObj->updateUser($user));
?>