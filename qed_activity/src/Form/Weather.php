<?php
namespace Drupal\qed_activity\Form;

use Drupal\weather\WeatherServices;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormState;
use Drupal\qed_activity\GetdataService;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * Configure example settings for this site.
 */
class Weather extends ConfigFormBase {
  protected $service_obj;

  public function __construct(GetdataService $service_obj) {
    $this->service_obj = $service_obj;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('qed_activity.get_appid')
    );
  }

  public function getFormId() {
    return 'weather_form';
  }

  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames() {
    return [
      'qed_activity.settings',
    ];
  }
 /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $data = $this->service_obj->get_Appid();
    dsm($data);
    $config = $this->config('qed_activity.settings');

    $config_appid = $config->get('weather.appid');
    $default_appid = empty($data) ? $config_appid : $data;

       $form['app_id'] = array(
        '#type' => 'textfield',
        '#title' => $this->t('App ID'),
        '#placeholder' => 'App ID',
        '#default_value' => $default_appid,
      );
      $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Save configuration'),
      );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
     $connection = \Drupal::database();
     $uid   = $this->currentUser()->id();
     $query = $connection->insert('weather_table')->fields([
    'app_id' => $form_state->getValue('app_id'),
  ])
  ->execute();
  return parent::submitForm($form, $form_state);
  }

}
