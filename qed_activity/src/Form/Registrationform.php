<?php
namespace Drupal\qed_activity\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\qed_activity\InsertdataService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountProxy;

/**
 *  Activity: Form API Extended: DIC & Database
 */
class Registrationform extends FormBase {
 protected $insert_obj;
 //protected $current_user;
 //AccountProxy  $current_user

  public function getFormId() {
    return 'qed_activity_settings';
  }

  public function __construct(InsertdataService $insert_obj) {
   $this->insert_obj = $insert_obj;
   //$this->current_user = $current_user;
 }

public static function create(ContainerInterface $container) {
  return new static($container->get('qed_activity.user_info_insert'));
}

public function buildForm(array $form, FormStateInterface $form_state) {

    $form['first_name'] = array(
      '#type' => 'textfield',
      '#title' => 'First Name',
      '#required' => TRUE,
      '#attributes' => array('placeholder' => t('Enter first Name'),)
    );

    $form['last_name'] = array(
      '#type' => 'textfield',
      '#title' => 'Last Name',
      '#required' => TRUE,
      '#attributes' => array('placeholder' => t('Enter last Name'),)
    );
$last_record = $this->insert_obj->getMsg();
 dpm($last_record);

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );
    return $form;
}

public function submitForm(array &$form, FormStateInterface $form_state) {

     //$userid = $this->current_user->id();
  $user = $this->currentUser();
  $userid = $user->id();


    $first_name = $form_state->getValue('first_name');
     $last_name = $form_state->getValue('last_name');
    $this->insert_obj->insertData($userid,$first_name ,$last_name);

  //$form_state->set
   // \Drupal\Core\Cache\Cache::invalidateTags(array('todo_item'));

}

public function validateForm(array &$form, FormStateInterface $form_state) {
  // if (strlen($form_state->getValue('name')) <= 5) {
  //     $form_state->setErrorByName('name', $this->t('Name should have minimum 5 characters'));
  //   }
  //   else{
  //     drupal_set_message("Sucessfully inserted");

  //   }
  }
}
