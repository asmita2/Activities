<?php
namespace Drupal\qed_activity\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Connection;

class UserForm extends FormBase {

  public function getFormId() {
    return 'qed_activity_settings';
  }
/**
 * @param  array
 * @param  FormStateInterface
 * @return [type]
 */
public function buildForm(array $form, FormStateInterface $form_state) {

    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => 'Name',
      '#required' => TRUE,
      '#attributes' => array('placeholder' => t('Enter Name'),)
    );

    $form['message'] = array(
      '#type' => 'textarea',
      '#title' => 'Mesaage',
      '#required' => TRUE,
      '#attributes' => array('placeholder' => t('Enter Message'),)
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );
    return $form;
}

public function submitForm(array &$form, FormStateInterface $form_state) {
     $connection = \Drupal::database();
     $uid   = $this->currentUser()->id();
     $query = $connection->insert('user_information')->fields([
    'uid' => $uid,
    'message' => $form_state->getValue('message'),
    'name' => $form_state->getValue('name'),
  ])
  ->execute();
}

public function validateForm(array &$form, FormStateInterface $form_state) {
  if (strlen($form_state->getValue('name')) <= 5) {
      $form_state->setErrorByName('name', $this->t('Name should have minimum 5 characters'));
    }
    else{
      drupal_set_message($form_state->getValue('name')."Sucessfully inserted");

    }
  }
}
