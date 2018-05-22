<?php
namespace Drupal\qed_activity\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\qed_activity\InsertdataService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *  Activity: Form API Extended: DIC & Database
 *            Form API Extended: #states & AJAX
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
    $form['qualification'] = [
    '#type' => 'select',
    '#title' => $this
      ->t('Select your Qualification'),
    '#options' => [
      'UG' => $this->t('UG'),
      'PG' => $this->t('PG'),
      'other' => $this->t('Other'),
      ],
      '#default_value' => 0,
    ];

    $form['other_option'] = [
     '#type' =>'textfield',
      '#title' => 'Other ',
      '#states' =>[
      'visible' =>[
       ':input[name ="qualification"]' => ['value' =>'other'],
      ],
    ],
    '#default_value' => '',
    ];

    $form['Country'] = [
      '#type' => 'select',
      '#title' => $this->t('Select your Country'),
      '#options' => [
        'India' => $this->t('India'),
        'UK' => $this->t('UK'),
        ],
        '#required' => TRUE,
        '#default_value' => pg_field_is_null(result, row, feild),
      ];

    $form['India_States'] = [
         '#type' => 'select',
         '#title' => 'Select state',
         '#options' => [
           'Maharashtra' => $this->t('Maharashtra'),
           'Jammu & kashmir' => $this->t('Jammu & kashmir'),
           'Gujrat' => $this->t('Gujrat'),
           'Rajasthan' => $this->t('Rajasthan'),
           'Uttarpradesh' => $this->t('Uttarpradesh'),
           'Jharkhand' => $this->t('Jharkhand'),
           'karnataka' => $this->t('karnathaka'),
           'Tamil Nadu' => $this->t('Tamil Nadu'),
         ],
         '#states' =>[
          'visible' =>[
          ':input[name ="Country"]' => ['value' =>'India'],
          ],
        ],

       ];

    $form['Uk_States'] = [
         '#type' => 'select',
         '#title' => 'Select state',
         '#options' => [
           'London' => $this->t('London'),
           'Chelsea' => $this->t('Chelsea'),
           'LiverPool' => $this->t('LiverPool'),
           'southHam' => $this->t('southHam'),
           'Tottenham' => $this->t('Tottenham'),
         ],
         '#states' =>[
          'visible' =>[
          ':input[name ="Country"]' => ['value' =>'UK'],
          ],
        ],
      ];


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
    $qualification = $form_state->getValue('qualification');
    $state  = '';

    if(($Country = $form_state->getValue('Country')) == 'India')
    {
      $state = $form_state->getValue('India_States');
    }
    else{
       $state = $form_state->getValue('Uk_States');
    }

    $this->insert_obj->insertData($userid, $first_name, $last_name, $qualification,$Country,$state);
    $request_time = \Drupal::time()->getCurrentTime();
    \Drupal::state()->set('submissionTime',$request_time);
  }
}
