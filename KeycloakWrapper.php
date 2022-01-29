<?php
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
?>