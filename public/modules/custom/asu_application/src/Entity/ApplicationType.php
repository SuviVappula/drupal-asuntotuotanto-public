<?php
namespace Drupal\asu_application\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
/**
 * Application Type
 *
 * @ConfigEntityType(
 *   id = "application_type",
 *   label = @Translation("Application Type"),
 *   bundle_of = "application_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   config_prefix = "application_type",
 *   config_export = {
 *     "id",
 *     "label",
 *   },
 *   handlers = {
 *     "form" = {
 *       "default" = "Drupal\asu_application\Form\ApplicationTypeEntityForm",
 *       "add" = "Drupal\asu_application\Form\ApplicationTypeEntityForm",
 *       "edit" = "Drupal\asu_application\Form\ApplicationTypeEntityForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   admin_permission = "administer site configuration",
 *   links = {
 *     "canonical" = "/admin/structure/application_type/{application_type}",
 *     "add-form" = "/admin/structure/application_type/add",
 *     "edit-form" = "/admin/structure/application_type/{application_type}/edit",
 *     "delete-form" = "/admin/structure/application_type/{application_type}/delete",
 *     "collection" = "/admin/structure/application_type",
 *   }
 * )
 */
class ApplicationType extends ConfigEntityBundleBase {
  /**
   * The machine name of the entity.
   *
   * @var string
   */
  protected $id;

  /**
   * The human-readable name of the entity.
   *
   * @var string
   */
  protected $label;
}
