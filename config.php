<?php
require_once __DIR__ . '/client/vendor/autoload.php';
require_once __DIR__ . '/KeycloakWrapper.php';

ini_set('display_errors', 1);

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
$keycloakObj = new KeycloakWrapper($config);
print("<pre>");
?>