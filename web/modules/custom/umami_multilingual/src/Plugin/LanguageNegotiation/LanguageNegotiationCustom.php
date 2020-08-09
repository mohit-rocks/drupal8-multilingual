<?php

namespace Drupal\umami_multilingual\Plugin\LanguageNegotiation;

use Drupal\language\LanguageNegotiationMethodBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Custom Language Negotiation Plugins.
 *
 * @LanguageNegotiation(
 *   id = \Drupal\umami_multilingual\Plugin\LanguageNegotiation\LanguageNegotiationCustom::METHOD_ID,
 *   weight = -1,
 *   name = @Translation("Custom Language Negotiation"),
 *   description = @Translation("Language from the custom query parameters."),
 * )
 */
class LanguageNegotiationCustom extends LanguageNegotiationMethodBase {

  /**
   * The language negotiation method id.
   */
  const METHOD_ID = 'language-custom';

  /**
   * {@inheritdoc}
   */
  public function getLangcode(Request $request = NULL) {
    $langcode = NULL;

    if ($this->languageManager && $request && $request->query->get('test-language') !== NULL) {
      $query_langcode = $request->query->get('test-language');
      $langcodes = array_keys($this->languageManager->getLanguages());
      if (in_array($query_langcode, $langcodes)) {
        $langcode = $query_langcode;
      }
    }

    return $langcode;
  }

}
