<?php

namespace Drupal\asu_application\EventSubscriber;

use Drupal\asu_api\Exception\ApplicationRequestException;
use Drupal\asu_api\Api\BackendApi\Request\ApplicationRequest;
use Drupal\asu_api\Api\BackendApi\BackendApi;
use Drupal\asu_application\Event\ApplicationEvent;
use Drupal\Core\Messenger\MessengerTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Application subscriber.
 */
class ApplicationSubscriber implements EventSubscriberInterface {

  use MessengerTrait;

  /**
   * Backend api.
   *
   * @var \Drupal\asu_api\Api\BackendApi\BackendApi
   */
  private BackendApi $backendApi;
  /**
   * Logger.
   *
   * @var \Psr\Log\LoggerInterface
   */
  private LoggerInterface $logger;

  /**
   * Constructor.
   *
   * @param \Psr\Log\LoggerInterface $logger
   *   Logger.
   * @param \Drupal\asu_api\Api\BackendApi\BackendApi $backendApi
   *   Backend api.
   */
  public function __construct(LoggerInterface $logger, BackendApi $backendApi) {
    $this->logger = $logger;
    $this->backendApi = $backendApi;
  }

  /**
   * Get subscribed events.
   *
   * @return array
   *   The event names to listen to.
   */
  public static function getSubscribedEvents() {
    return [
      ApplicationEvent::EVENT_NAME => 'sendApplication',
    ];
  }

  /**
   * Sends application to backend.
   *
   * @param \Drupal\asu_application\Event\ApplicationEvent $applicationEvent
   *   Application event.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function sendApplication(ApplicationEvent $applicationEvent) {
    $entity_type = 'asu_application';
    $entity_id = $applicationEvent->getApplicationId();

    /** @var \Drupal\asu_application\Entity\Application $entity */
    $entity = \Drupal::entityTypeManager()->getStorage($entity_type)->load($entity_id);
    $user = $entity->getOwner();

    try {
      $request = new ApplicationRequest($user, $entity);
      $content = $this->backendApi
        ->getApplicationService()
        ->sendApplication($request)
        ->getContent();

      // @todo implement rest of the logic.
    }
    catch (ApplicationRequestException $e) {
      // Backend returned non 2xx response.
      // Queue worker maybe.
      $this->logger->critical('Unexpected ApplicationRequestException while sending application to backend: application id ' . $entity->id() . ' ' . $e->getMessage());
    }
    catch (\Exception $e) {
      // Any other exception.
      $this->logger->critical('Unexpected exception while sending application to backend: application id ' . $entity->id() . '. ' . $e->getMessage());
    }

  }

}
