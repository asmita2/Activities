<?php
namespace Drupal\qed_activity\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\Insertdata;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *  Activity: Form API Extended: DIC & Database
 */
class Registrationform extends FormBase {
 protected $insert_obj;

  public function getFormId() {
    return 'qed_activity_settings';
  }

  public function __construct(InsertdataService $serviceobj) {
   $this->serviceobj = $serviceobj;
 }
public static function create(ContainerInterface $container) {  return new static(
  $container->get('user_info_insert')  );
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

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );
    return $form;
}

public function submitForm(array &$form, FormStateInterface $form_state) {
$uid = $form_state->getValue('userid');
    $textmsg = $form_state->getValue('todotext');
    $this->serviceobj->insertData($uid , $textmsg);
    \Drupal\Core\Cache\Cache::invalidateTags(array('todo_item'));

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
