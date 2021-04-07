<?php

namespace Drupal\asu_api\Api\DrupalApi\Service;

use Drupal\asu_api\Api\BackendApi\Response\ApplicationResponse;
use Drupal\asu_api\Api\RequestHandler;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class ApplicationService {
  /**
   * @var RequestHandler
   */
  private RequestHandler $requestHandler;

  public function __construct(RequestHandler $requestHandler) {
    $this->requestHandler = $requestHandler;
  }

  public function sendApplication(ApplicationRequest $request){
    $httpRequest = $this->buildRequest($request);
    $response = $this->requestHandler->send($httpRequest);
    return ApplicationResponse::createFromHttpResponse($response);
  }

  private function buildRequest(ApplicationRequest $request): RequestInterface{
    $payload = $request->toArray();
    return new Request(
      $request->getMethod(),
      $request->getPath(),
      ['Content-Type' => 'application/json'],
      $payload
    );
  }


}
