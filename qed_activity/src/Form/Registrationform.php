<?php
namespace Drupal\qed_activity\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\qed_activity\InsertdataService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *  Activity: Form API Extended: DIC & Database
 */
class Registrationform extends FormBase {
  protected $insert_obj;


  public function getFormId() {
    return 'qed_activity_settings';
  }

  public function __construct(InsertdataService $insert_obj){
    $this->insert_obj = $insert_obj;
  }

  public static function create(ContainerInterface $container) {
    return new static($container->get('qed_activity.user_info_insert'));
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $user_feilds = $this->insert_obj->get_User_Details();

    $form['first_name'] = array(
      '#type' => 'textfield',
      '#title' => 'First Name',
      '#required' => TRUE,
      '#attributes' => array(
        'placeholder' => t('Enter first Name')
      ),
      '#default_value' => !empty($user_feilds) ? $user_feilds['first_name'] : 0
    );

    $form['last_name'] = array(
      '#type' => 'textfield',
      '#title' => 'Last Name',
      '#required' => TRUE,
      '#attributes' => array(
        'placeholder' => t('Enter last Name')
      ),
      '#default_value' => !empty($user_feilds) ? $user_feilds['last_name'] : 0
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit')
    );
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $user   = $this->currentUser();
    $userid = $user->id();


    $first_name = $form_state->getValue('first_name');
    $last_name  = $form_state->getValue('last_name');
    $this->insert_obj->insertData($userid, $first_name, $last_name);

  }
}
