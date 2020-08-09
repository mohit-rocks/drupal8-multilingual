<?php

namespace Drupal\umami_multilingual\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class AdminConfigForm.
 */
class AdminConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'umami_multilingual.adminconfig',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'admin_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('umami_multilingual.adminconfig');
    $form['help_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Help Text'),
      '#description' => $this->t('Default help text.'),
      '#maxlength' => 255,
      '#size' => 64,
      '#default_value' => $config->get('help_text'),
    ];
    $form['default_description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Default Description'),
      '#description' => $this->t('Default description for the recipe.'),
      '#default_value' => $config->get('default_description'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('umami_multilingual.adminconfig')
      ->set('help_text', $form_state->getValue('help_text'))
      ->set('default_description', $form_state->getValue('default_description'))
      ->save();
  }

}
