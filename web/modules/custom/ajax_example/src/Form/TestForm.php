<?php

namespace Drupal\ajax_example\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;

/**
 * Provides a form with Ajax API.
 */
class TestForm extends FormBase
{
  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'dependent_element_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['select'] = [
      '#type' => 'select',
      '#title' => $this->t('Select'),
      '#options' => [
        'none' => $this->t('none'),
        'fruits' => $this->t('Fruits'),
        'vegies' => $this->t('Vegetables'),
      ],
      '#ajax' => [
        'callback' => '::myAjaxCallback',
        'event' => 'change',
        'wrapper' => 'edit-options',
        'progress' => [
          'type' => 'throbber',
          'message' => $this->t('Loading...'),
        ],
      ]
    ];

    if (empty($form_state->getValue('select'))) {
      $selectedValue = '';
    } else {
      $selectedValue = $form_state->getValue('select');
    }
    
    $form['depenedent_element'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Options'),
      '#options' => static::getOptions($selectedValue),
      '#prefix' => '<div id="edit-options">',
      '#suffix' => '</div>',
    ];

    $form['wrapper'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Example of AjaxCommands'),
    ];
    $form['wrapper']['input_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter text to display below'),
      '#ajax' => [
        'callback' => '::changeText',
        'event' => 'change',
        'wrapper' => 'markup-text',
        'progress' => [
          'type' => 'throbber',
          'message' => $this->t('Loading...'),
        ],
      ]
    ];
    $form['wrapper']['help'] = [
      '#type' => 'markup',
      '#markup' => 'Nothing in above textfield',
      '#prefix' => '<div id="markup-text">',
      '#suffix' => '</div>',
    ];

    return $form;
  }

  public function myAjaxCallback(array &$form, FormStateInterface $form_state) {
    return $form['depenedent_element'];
  }

  public function changeText(array &$form, FormStateInterface $form_state) {
    $txtValue = $form_state->getValue('input_text');
    $form['wrapper']['help'] = '<div id="markup-text">Entered text is: ' . $txtValue . '</div>';
    $response = new AjaxResponse();
    $response->addCommand(new ReplaceCommand('#markup-text', $form['wrapper']['help']));
    return $response;
  }

  /**
  * {@inheritdoc}
  */
  public function submitForm(array & $form, FormStateInterface $form_state) {
    
  }

  /**
   * Helper function to populate the checkboxes.
   *
   * @param string $selectedValue
   *   This will determine which set of options is returned.
   *
   * @return array
   *   Checkboxes options
   */
  public static function getOptions($selectedValue = '') {
    switch ($selectedValue) {
      case 'fruits':
        $options = ["mango" => "Mango", "banana" => "Banana", "grapes" => "Grapes"];
        break;
    case 'vegies':
        $options = ["broccoli" => "Broccoli", "cauliflower" => "Cauliflower", "green_beans" => "Green Beans"];
        break;
    default:
      $options = ['none' => 'none'];
      break;
    }
    return $options;
  }
}
