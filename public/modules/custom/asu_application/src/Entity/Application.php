<?php

namespace Drupal\asu_application\Entity;

use Drupal\Core\Entity\EditorialContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Field\FieldDefinition;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\user\EntityOwnerTrait;
/**
 * Defines the asu_application entity.
 *
 * @ContentEntityType(
 *   id = "asu_application",
 *   label = @Translation("Application"),
 *   base_table = "asu_application",
 *   data_table = "asu_application_data",
 *   revision_table = "asu_application_revision",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "bundle" = "bundle",
 *     "owner" = "uid",
 *     "revision" = "vid",
 *     "published" = "status",
 *   },
 *   handlers = {
 *     "list_builder" = "Drupal\Core\Entity\EntityListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "default" = "Drupal\Core\Entity\ContentEntityForm",
 *       "add" = "Drupal\Core\Entity\ContentEntityForm",
 *       "edit" = "Drupal\Core\Entity\ContentEntityForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   revision_metadata_keys = {
 *     "revision_user" = "revision_user",
 *     "revision_created" = "revision_created",
 *     "revision_log_message" = "revision_log",
 *   },
 *   links = {
 *     "canonical" = "/asu_application/{asu_application}",
 *     "add-page" = "/asu_application/add",
 *     "add-form" = "/asu_application/add/{application_type}",
 *     "edit-form" = "/asu_application/{asu_application}/edit",
 *     "delete-form" = "/asu_application/{asu_application}/delete",
 *     "collection" = "/admin/content/application",
 *   },
 *   admin_permission = "administer site configuration",
 *   bundle_entity_type = "application_type",
 *   field_ui_base_route = "entity.application_type.edit_form",
 * )
 */
class Application extends EditorialContentEntityBase {
  use EntityOwnerTrait;

  public static function bundleFieldDefinitions(EntityTypeInterface $entity_type, $bundle, array $base_field_definitions)
  {
    $fields = parent::bundleFieldDefinitions($entity_type, $bundle, $base_field_definitions);
    /*
    $fields['project'] = FieldDefinition::create('entity_reference')
      ->setLabel(t('Project'))
      ->setSettings([
        'target_type' => 'project',
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);
    */




    return $fields;

  }

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type)
  {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['status'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Revision ID'))
      ->setDescription(t('The revision ID.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['status'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Revision ID'))
      ->setDescription(t('The revision ID.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['project_id'] = FieldDefinition::create('integer')
      ->setLabel(t('Selected project'))
      ->setDescription(t('Selected project'));

    $field['apartment_ids'] = FieldDefinition::create('integer')
      ->setLabel(t('Apartments'))
      ->setDescription(t('apartments'));

    return $fields;
  }

}
