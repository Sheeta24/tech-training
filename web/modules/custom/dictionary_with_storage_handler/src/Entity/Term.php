<?php
/**
 * @file
 * Contains \Drupal\dictionary\Entity\DictionaryTerm.
 */

namespace Drupal\dictionary\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Defines the DictionaryTerm entity.
 *
 * @ingroup dictionary
 *
 *
 * @ContentEntityType(
 *   id = "dictionary_term",
 *   label = @Translation("Dictionary Term entity"),
 *   handlers = {
 *     "storage" = "Drupal\dictionary\DictionaryTermStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\dictionary\Entity\Controller\TermListBuilder",
 *     "form" = {
 *       "add" = "Drupal\dictionary\Form\TermForm",
 *       "edit" = "Drupal\dictionary\Form\TermForm",
 *       "delete" = "Drupal\dictionary\Form\TermDeleteForm",
 *     },
 *     "access" = "Drupal\dictionary\TermAccessControlHandler",
 *   },
 *   base_table = "dictionary_term",
 *   admin_permission = "administer dictionary_term entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "created" = "created",
 *     "changed" = "changed",
 *     "pl" = "pl",
 *     "en" = "en",
 *   },
 *   links = {
 *     "canonical" = "/dictionary_term/{dictionary_term}",
 *     "edit-form" = "/dictionary_term/{dictionary_term}/edit",
 *     "delete-form" = "/dictionary_term/{dictionary_term}/delete",
 *     "collection" = "/dictionary_term/list"
 *   }
 * )
 */
class Term extends ContentEntityBase {

  use EntityChangedTrait;
  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   *
   * Define the field properties here.
   *
   * Field name, type and size determine the table structure.
   *
   * In addition, we can define how the field and its content can be manipulated
   * in the GUI. The behaviour of the widgets used can be determined here.
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Term entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Contact entity.'))
      ->setReadOnly(TRUE);

    // Name field for the contact.
    // We set display options for the view as well as the form.
    // Users with correct privileges can change the view and edit configuration.
    $fields['pl'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Polish'))
      ->setDescription(t('Polish version.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -6,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['en'] = BaseFieldDefinition::create('string')
      ->setLabel(t('English'))
      ->setDescription(t('English version.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
