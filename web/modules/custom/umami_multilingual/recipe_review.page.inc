<?php

/**
 * @file
 * Contains recipe_review.page.inc.
 *
 * Page callback for Recipe review entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Recipe review templates.
 *
 * Default template: recipe_review.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_recipe_review(array &$variables) {
  // Fetch RecipeReview Entity Object.
  $recipe_review = $variables['elements']['#recipe_review'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
