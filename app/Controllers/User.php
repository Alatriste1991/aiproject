<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class User extends BaseController
{
    private $session = '';
    private $userModel = '';
    function __construct()
    {
        $this->session = session();
        $this->userModel = new \App\Models\UserModel();
    }
    
    public function checkUser($id){
        $params['user_id'] = $id;

        return $this->userModel->getUser($params)['status'];


    }

    public function registration(){

        if($this->request->isAJAX()){

            $response = array('error'=>0,'info'=>null);

            $values = array
            (
                'reg-mail'						=> $_POST['reg-mail'],
                'reg-username'					=> $_POST['reg-username'],
                'reg-password1'					=> $_POST['reg-password1'],
                'reg-password2'					=> $_POST['reg-password2'],
            );

            if(!filter_var($values['reg-mail'],FILTER_VALIDATE_EMAIL))
            {
                $response['error']=1;
                $response['info'][]=array('fieldId'=>'reg-mail','message'=>'Invalid email format!');
            }
            if($values['reg-username'] == '')
            {
                $response['error']=1;
                $response['info'][]=array('fieldId'=>'reg-username','message'=>'User name cannot be empty!');
            }else{

                if(strlen($values['reg-username']) < 3 || strlen($values['reg-username']) > 10)
                {
                    $response['error']=1;
                    $response['info'][]=array('fieldId'=>'reg-username','message'=>'the username must be at least three and a maximum of 10 characters!');
                }
            }

            if($values['reg-password1'] == '')
            {
                $response['error']=1;
                $response['info'][]=array('fieldId'=>'reg-password1','message'=>'Password cannot be empty!');
            }else{
                if(strlen($values['reg-password1']) < 9 || strlen($values['reg-password1']) > 16){
                    $response['error']=1;
                    $response['info'][]=array('fieldId'=>'reg-password1','message'=>'the password must be at least 8 and a maximum of 15 characters!');
                }else{
                    if($values['reg-password2'] == ''){
                        $response['error']=1;
                        $response['info'][]=array('fieldId'=>'reg-password2','message'=>'Password cannot be empty!');
                    }else{
                        if($values['reg-password1'] != $values['reg-password2']){
                            $response['error']=1;
                            $response['info'][]=array('fieldId'=>'reg-password2','message'=>'Two password not equal!');
                        }
                    }
                }
            }

            if($response['error']==0){
                $params = array(
                    'user_email'     => $values['reg-mail']
                );

                $user = $this->userModel->getUser($params);

                if($user != false){
                    $response['error']=1;
                    $response['info'][]=array('fieldId'=>'reg-mail','message'=>'This email address is already registered!');
                }else{

                    $data = array(
                        'user_name'     => $values['reg-username'],
                        'user_email'    => $values['reg-mail'],
                        'password'      => password_hash($values['reg-password1'],PASSWORD_DEFAULT),
                        'status'        => true,
                    );

                    $addUser = $this->userModel->addUser($data);

                    if($addUser == false){
                        $response['error']=1;
                        $response['info'][]=array('fieldId'=>'reg-mail','message'=>'Registration unsuccessful!');
                    }else{
                        $response['error']=0;
                        $response['info'][]=array('fieldId'=>'submit','message'=>'Registration successful');
                        $response['id'] = $addUser;

                    }
                }

            }

            print json_encode($response);

        }else{
            return view('frontend/header')
                .view('frontend/layouts/registration')
                .view('frontend/footer');
        }

    }
    
    public function profile($id){
        
        $status = $this->checkUser($id);

        $data = array();

        if($status == 0){
            $data['message'] = 'Profile blocked!';
        }elseif($status == 1){
            $data['message'] = 'Profile not verified yet!';
        }/*else{

        }*/

        return view('frontend/header')
            .view('frontend/layouts/profile',$data)
            .view('frontend/footer');
    }
}