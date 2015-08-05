<?php
/**
 * @file
 * Contains \Drupal\addthis\Plugin\Field\FieldFormatter\AddThisBasicToolboxFormatter.
 */

namespace Drupal\addthis\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'addthis_disabled' formatter.
 *
 * @FieldFormatter(
 *   id = "addthis_basic_toolbox",
 *   label = @Translation("AddThis Basic Toolbox"),
 *   field_types = {
 *     "addthis"
 *   }
 * )
 */
class AddThisBasicToolboxFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'share_services' => 'facebook,twitter',
      'buttons_size' => 'addthis_16x16_style',
      'counter_orientation' => 'horizontal',
      'extra_css' => '',
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element = array();

    $element['share_services'] = array(
      '#title' => t('Services'),
      '#type' => 'textfield',
      '#size' => 80,
      '#default_value' => $this->getSetting('share_services'),
      '#required' => TRUE,
      '#element_validate' => array($this, 'addThisDisplayElementServicesValidate'),
      '#description' =>
        t('Specify the names of the sharing services and seperate them with a , (comma). <a href="http://www.addthis.com/services/list" target="_blank">The names on this list are valid.</a>') .
        t('Elements that are available but not ont the services list are (!services).',
          array('!services' => 'bubble_style, pill_style, tweet, facebook_send, twitter_follow_native, google_plusone, stumbleupon_badge, counter_* (several supported services), linkedin_counter')
        ),
    );
    $element['buttons_size'] = array(
      '#title' => t('Buttons size'),
      '#type' => 'select',
      '#default_value' => $this->getSetting('buttons_size'),
      '#options' => array(
        'addthis_16x16_style' => t('Small (16x16)'),
        'addthis_32x32_style' => t('Big (32x32)'),
      ),
    );
    $element['counter_orientation'] = array(
      '#title' => t('Counter orientation'),
      '#description' => t('Specify the way service counters are oriented.'),
      '#type' => 'select',
      '#default_value' => $this->getSetting('counter_orientation'),
      '#options' => array(
        'horizontal' => t('Horizontal'),
        'vertical' => t('Vertical'),
      )
    );
    $element['extra_css'] = array(
      '#title' => t('Extra CSS declaration'),
      '#type' => 'textfield',
      '#size' => 40,
      '#default_value' => $this->getSetting('extra_css'),
      '#description' => t('Specify extra CSS classes to apply to the toolbox'),
    );

    return $element;
  }

  public function addThisDisplayElementServicesValidate(array $element, FormStateInterface $form_state){
    $bad = FALSE;

    $services = trim($element['#value']);
    $services = str_replace(' ', '', $services);

    if (!preg_match('/^[a-z\_\,0-9]+$/', $services)) {
      $bad = TRUE;
    }
    // @todo Validate the service names against AddThis.com. Give a notice when there are bad names.

    // Return error.
    if ($bad) {
      form_error($element, t('The declared services are incorrect or nonexistent.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items) {
    //@TODO Implement viewElements()
    $element = array();
    $display_type = 'addthis_disabled';



    $markup = array(
      '#display' => array(),
    );
  }

}