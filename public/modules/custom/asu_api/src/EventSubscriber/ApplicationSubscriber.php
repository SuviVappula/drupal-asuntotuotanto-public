<?

namespace Drupal\asu_api\EventSubscriber;

use Composer\EventDispatcher\EventSubscriberInterface;
use Drupal\asu_api\ApplicationEvent;
use Drupal\asu_api\BackendApi\Request\ApplicationRequest;
use Drupal\asu_api\Api\BackendApi\BackendApi;
use Drupal\Core\Messenger\MessengerTrait;
use Psr\Log\LoggerTrait;

class ApplicationSubscriber implements EventSubscriberInterface {

  use MessengerTrait;
  use LoggerTrait;

  private BackendApi $backendApi;

  public function __construct(BackendApi $backendApi) {
    $this->backendApi = $backendApi;
  }

  /**
   * @inheritDoc
   */
  public static function getSubscribedEvents() {
    $events[ApplicationEvent::EVENT_NAME] = ['sendApplication'];
    return $events;
  }

  /**
   * Sends application to backend.
   */
  public function sendApplication(ApplicationEvent $applicationEvent) {
    $entity_type = 'asu_application';
    $entity_id = $applicationEvent->getApplicationId();

    /** @var \Drupal\asu_application\Entity\Application $entity */
    $entity = \Drupal::entityTypeManager()->getStorage($entity_type)->load($entity_id);
    $user = $entity->getOwner();

    $request = new ApplicationRequest($user, $entity);

    try {
      $content = $this->backendApi
        ->getApplicationService()
        ->sendApplication($request)
        ->getContent();

      // TODO: impelment rest of the logic.

    }
    catch(\Exception $e) {
      $this->log('critical', 'Exception while sending application to backend: application id ' . $entity->id() . '. ' . $e->getMessage());
    }
  }

}
