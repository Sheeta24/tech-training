<?php
namespace Drupal\dictionary;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;

/**
 * Defines the storage handler class for Dictionary Term entities.
 */
class DictionaryTermStorage extends SqlContentEntityStorage implements DictionaryTermStorageInterface {
  
  /**
   * {@inheritdoc}
   */
    public function getTotalDictionaryTerms()
    {
        return $this->database->query('SELECT COUNT(*) FROM {dictionary_term} ')->fetchField();
    }
}