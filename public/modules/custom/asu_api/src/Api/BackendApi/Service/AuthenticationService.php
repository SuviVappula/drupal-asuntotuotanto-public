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
  public function handleAuthentication(UserInterface $user): bool {
    if (!$this->isApiAuthenticated($user)) {
      try {
        $authenticationResponse = $this->authenticate($user);
        $this->session->set('token', $authenticationResponse->getToken());
        return TRUE;
      }
      catch (\Exception $e) {
        // Token is not set and authentication failed. Emergency.
        return FALSE;
      }
    }
    return FALSE;
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
      // if($this->isTokenAlive($token)){
      return TRUE;
      // }
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
    $tokenTTL = 1770;
    $token = json_decode(base64_decode($token));
    // @todo Get the created date from token.
    // $tokenCreated = (new \DateTime($token['asd']))->getTimestamp();
    $tokenCreated = $token['asd'];
    return ((strtotime('now') - strtotime($tokenCreated)) < $tokenTTL);
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

}
