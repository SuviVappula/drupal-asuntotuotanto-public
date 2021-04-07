<?php

namespace Drupal\asu_api\Api\BackendApi\Service;

use Drupal\asu_api\Api\BackendApi\Response\ApplicationResponse;
use Drupal\asu_api\Api\ServiceBase;
use Drupal\asu_api\BackendApi\Request\ApplicationRequest;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class ApplicationService extends ServiceBase {
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

