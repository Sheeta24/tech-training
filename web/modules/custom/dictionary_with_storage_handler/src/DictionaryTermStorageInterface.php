<?php

namespace Drupal\dictionary;

use Drupal\Core\Entity\ContentEntityStorageInterface;

/**
 * Defines an interface for dictionary term entity storage classes.
 */
interface DictionaryTermStorageInterface extends ContentEntityStorageInterface {

  /**
   * Provieds total number of Dictionary Term entities.
   * 
   * @return string
   *   An string containing number of Dictionary Term entities.
   */
  public function getTotalDictionaryTerms();

}
