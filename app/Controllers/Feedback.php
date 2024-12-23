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

    private $LogModel = '';

    /**
     * Home constructor.
     */
    function __construct()
    {
        $this->session = session();
        $this->is_logged_in();
        $this->feedbackModel = new \App\Models\FeedbackModel();
        $this->LogModel = new \App\Models\LoginModel();
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

        try{
            $response = array('error'=> 0,'info'=>null);
            $log = '';

            $values = array(
                'user_id'       => $user_id,
                'feedback_type' => $_POST['feedback_type'],
                'feedback_text' => $_POST['feedback_text'],
                //'created_time'  => date('Y-m-d H:i:s')
            );

            if($values['feedback_text'] == ''){

                $response['error'] = 1;
                $response['info'][]=array('fieldId'=> 'feedback-text','message'=>'Please fill this field!');
                $log .= "Empty feedback text - ";
            }

            if(strlen($values['feedback_text']) > 1000){

                $response['error'] = 1;
                $response['info'][]=array('fieldId'=> 'feedback-text','message'=>'Text legth too long, max 1000 character is allowed!');
                $log .= "Feedback text too long (length: " . strlen($values['feedback_text']) . ") - ";
            }

            // Logolás üres vagy hibás mezők esetén
            if ($log !== '') {
                $this->LogModel->warning('feedbackpost', $this->userInfo, "Invalid feedback submission: " . rtrim($log, ' - ') . " for User ID: {$user_id}",$user_id);
            }

            if($response['error'] == 0){

                $result = $this->feedbackModel->addFeedback($values);

                if($result){
                    $response['info'][]=array('fieldId'=>'submit','message'=>'Successful, thank you!');
                    $response['id'] = $user_id;

                    $this->LogModel->info('feedbackpost', $this->userInfo, "Feedback successfully submitted by User ID: {$user_id}",$user_id);
                }else{
                    $response['error'] = 1;
                    $response['info'][] = ['fieldId' => 'submit', 'message' => 'Failed to submit feedback. Please try again.'];
                    $this->LogModel->error('feedbackpost', $this->userInfo, "Failed to add feedback for User ID: {$user_id}",$user_id);
                }

            }

            return $this->response->setJSON($response);

        }catch (\Exception $e){
            $this->LogModel->error('feedbackpost', $this->userInfo, "Error during feedback submission: " . $e->getMessage(),$user_id);
        }
    }


}