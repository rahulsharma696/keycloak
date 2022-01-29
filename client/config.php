<?php
ini_set("display_errors", 1);
require_once __DIR__ . '/vendor/autoload.php';
//require_once("./src/KeycloackClient.php");

// $config = Keycloak\Admin\KeycloakClient::factory([
//   'realm' => 'master',
//   'username' => 'marc-david.jung@corgos.de',
//   'password' => 'Winter2021',
//   'client_id' => 'master-realm',
//   'baseUri' => 'https://authdev.corgos.de',
// ]);
// /{realm}/users/{id}/logout
$config = Keycloak\Admin\KeycloakClient::factory([
  'realm' => 'master',
  'grant_type' => 'client_credentials',
  'username' => 'admin',
  'password' => 'password',
  'client_id' => 'master-realm',
  'client_secret' => 'Vjlex0SfoYZC97WSzSNTLBkcfypokxE8',
  'baseUri' => 'http://localhost:8080',
  'custom_operations' => [
    'revokeSessionsForUser' => [
        'uri' => 'auth/admin/realms/{realm}/users/{id}/logout',
        'description' => 'Logout all the sessions for a specific user',
        'httpMethod' => 'POST',
        'parameters' => [
            'realm' => [
                'location' => 'uri',
                'description' => 'The Realm name',
                'type' => 'string',
                'required' => true,
            ],
            'id' => [
                'location' => 'uri',
                'type' => 'string',
                'required' => true,
            ],
        ],
    ],
  ]
]);

class KeycloakWrapper {
  
  private $config;
  
  function __construct($config) {
    $this->config = $config;
  }

  function getAllUsers() {
    return $this->config->getUsers();
  }

  private function configureResponse($response) {
    if (isset($response['content'])) return true;
    if (isset($response['errorMessage'])) return $response['errorMessage'];
    if (isset($response['error'])) return $response['error'];
  }

  function createUser($username, $firstName, $lastName, $email, $credentials, $enabled = true, $emailVerified = true) {
    $response = $this->config->createUser([
      'username' => $username,
      'firstName' => $firstName,
      'lastName' => $lastName,
      'email' => $email,
      'enabled' => $enabled,
      'emailVerified' => $emailVerified,
      'credentials' => $credentials
    ]);
    return $this->configureResponse($response);
  }

  function enableDisableUser($id, $enabled = true) {
    $response = $this->config->updateUser([
      'id' => $id,
      'enabled' => $enabled
    ]);
    return $this->configureResponse($response);
  }

  function updateUser($data) {
    $response = $this->config->updateUser($data);
    return $this->configureResponse($response);
  }

  function deleteUser($id) {
    $response = $this->config->deleteUser(['id' => $id]);
    return $this->configureResponse($response);
  }

  function logoutUserSession($id) {
    $response = $this->config->revokeSessionsForUser(['id' => $id]);
    return $this->configureResponse($response);
  }
}

print("<pre>");
$keycloakObj = new KeycloakWrapper($config);
// print_r($config);
print_r($keycloakObj->logoutUserSession('fa7032e1-3118-412e-9ab1-a2ea79f60517'));
// print_r($keycloakObj->getAllUsers());

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

// print_r($keycloakObj->createUser('test1', 'Rahul', 'Sharma', 'test1@test.com', [
//   [
//       'type'=>'password',
//       'value'=>'1234',
//   ],
// ]));

// print_r($keycloakObj->deleteUser('c2d4e295-a27a-4187-99f5-381e84e4a87d'));

// print_r($keycloakObj->updateUser($user));
// print_r($keycloakObj->logoutUserSession('c1d4e295-a27a-4187-99f5-381e84e4a87d'));

// print_r($keycloakObj->enableDisableUser('fa7032e1-3118-412e-9ab1-a2ea79f60517', true));

?>