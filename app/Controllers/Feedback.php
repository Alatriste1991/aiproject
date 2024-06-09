<?php


namespace App\Controllers;

use CodeIgniter\Controller;

/**
 * Class Home
 * @package App\Controllers
 */
class Feedback extends BaseController
{

    /**
     * @var array|bool|\CodeIgniter\Session\Session|float|int|object|string|null
     */
    private $session = '';

    /**
     * @var \App\Models\FeedbackModel|string
     */
    private $feedbackModel = '';

    /**
     * Home constructor.
     */
    function __construct()
    {
        $this->session = session();
        $this->is_logged_in();
        $this->feedbackModel = new \App\Models\FeedbackModel();
    }


    /**
     * @return string
     */
    public function index(){

        return view('frontend/header')
            .view('frontend/layouts/feedback/index')
            .view('frontend/footer');
    }


    /**
     * feedback_type:
     * 1 = bug report
     * 2 = vélemény
     * 3 = fejlesztési ötletek
     */
    public function feedbackpost(){

        $user_id = $this->session->get('login_data')['user_id'];

        $response = array('error'=> 0,'info'=>null);

        $values = array(
            'user_id'       => $user_id,
            'feedback_type' => $_POST['feedback_type'],
            'feedback_text' => $_POST['feedback_text'],
            //'created_time'  => date('Y-m-d H:i:s')
        );

        if($values['feedback_text'] == ''){

            $response['error'] = 1;
            $response['info'][]=array('fieldId'=> 'feedback-text','message'=>'Please fill this field!');

        }

        if(strlen($values['feedback_text']) > 1000){

            $response['error'] = 1;
            $response['info'][]=array('fieldId'=> 'feedback-text','message'=>'Text legth too long, max 1000 character is allowed!');

        }

        if($response['error'] == 0){

            $this->feedbackModel->addFeedback($values);

            $response['info'][]=array('fieldId'=>'submit','message'=>'Successful, thank you!');
            $response['id'] = $user_id;
        }

        print json_encode($response);

    }
}