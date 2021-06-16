<?php

namespace Drupal\asu_api\Api\BackendApi\Service;

use Drupal\asu_api\Api\BackendApi\Request\AuthenticationRequest;
use Drupal\asu_api\Api\BackendApi\Response\AuthenticationResponse;
use Drupal\asu_api\Api\RequestHandler;
use Drupal\user\UserInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Service handling user authentication.
 */
class AuthenticationService {

  /**
   * Request handler.
   *
   * @var \Drupal\asu_api\Api\RequestHandler
   */
  private RequestHandler $requestHandler;

  /**
   * User session.
   *
   * @var \Symfony\Component\HttpFoundation\Session\Session
   */
  private Session $session;

  /**
   * Constructor.
   *
   * AuthenticationService constructor.
   *
   * @param \Drupal\asu_api\Api\RequestHandler $requestHandler
   *   Request handler class.
   * @param \Symfony\Component\HttpFoundation\Session\Session $session
   *   User session.
   */
  public function __construct(RequestHandler $requestHandler, Session $session) {
    $this->requestHandler = $requestHandler;
    $this->session = $session;
  }

  /**
   * Handles user authentication.
   *
   * @param \Drupal\user\UserInterface $user
   *   Current user.
   *
   * @return bool
   *   Is authentication handled properly.
   */
  public function handleAuthentication(UserInterface $user): ?string {
    if (!$this->isApiAuthenticated($user)) {
      try {
        $authenticationResponse = $this->authenticate($user);
        $this->session->set('token', $authenticationResponse->getToken());
        return $authenticationResponse->getToken();
      }
      catch (\Exception $e) {
        \Drupal::messenger()->addMessage('exception: ' . $e->getMessage());
        // Token is not set and authentication failed. Emergency.
        return NULL;
      }
    } else {
      return $this->session->get('token');
    }
    return NULL;
  }

  /**
   * Check if user has a valid token for backend api.
   *
   * @param \Drupal\user\UserInterface $user
   *   Current user.
   *
   * @return bool
   *   Is user able to send authenticated requests to backend.
   */
  private function isApiAuthenticated(UserInterface $user): bool {
    if ($token = $this->session->get('token')) {
      // Return $this->isTokenAlive($token);
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Check if token is active.
   *
   * @param string $token
   *   Users authentication token.
   *
   * @return bool
   *   Is token still usable.
   */
  private function isTokenAlive(string $token): bool {
    $token = json_decode(base64_decode($token));
    #$tokenArray = explode($);
    // @todo Get the "exp" from token.
    $tokenCreated = $token['exp'];
    return strtotime('now') < $tokenCreated;
  }

  /**
   * Fetch new token.
   *
   * @param \Drupal\user\UserInterface $user
   *   Current user.
   *
   * @return \Drupal\asu_api\Api\BackendApi\Response\AuthenticationResponse
   *   Authentication response.
   *
   * @throws \Drupal\asu_api\Exception\RequestException
   */
  private function authenticate(UserInterface $user): AuthenticationResponse {
    $request = new AuthenticationRequest($user);
    $response = $this->requestHandler->post($request->getPath(), $request->toArray());
    return AuthenticationResponse::createFromHttpResponse($response);
  }

  /**
   *
   */
  public function getUserToken(): string {
    $this->session->get('token');
  }

}
