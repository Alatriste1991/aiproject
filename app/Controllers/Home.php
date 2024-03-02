<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class Home extends BaseController
{
    private $session = '';
    function __construct()
    {
        $this->session = session();
    }

    public function index(): string
    {

        if($this->session->has('login_data')){

            $data = array(
                'user_name' => $this->session->get('login_data')['user_name'],
                'user_id' => $this->session->get('login_data')['user_id']
            );
            return view('frontend/header')
                .view('frontend/layouts/main', $data)
                .view('frontend/footer');
        }else{
            return view('frontend/header')
                .view('frontend/layouts/main')
                .view('frontend/footer');
        }

    }

    public function login(){

        if($this->request->isAJAX()){

            $model = new \App\Models\UserModel();

            $response = array('error'=>0,'info'=>null);

            $values = array
            (
                'login-mail'						=> $_POST['login-mail'],
                'login-password'					=> $_POST['login-password'],
            );



            if(!filter_var($values['login-mail'],FILTER_VALIDATE_EMAIL))
            {
                $response['error']=1;
                $response['info'][]=array('fieldId'=>'login-mail','message'=>'Invalid email format!');
            }


            if(!mb_strlen($values['login-password']))
            {
                $response['error']=1;
                $response['info'][]=array('fieldId'=>'login-password','message'=>'Password cannot be empty!');
            }else{

                $params = array(
                    'status'    => true,
                    'user_email'     => $values['login-mail']
                );

                $user = $model->getUser($params);

                if($user == false){
                    $response['error']=1;
                    $response['info'][]=array('fieldId'=>'login-password','message'=>'User not found');
                }else{

                    if(!password_verify($values['login-password'],$user['password'])){
                        $response['error']=1;
                        $response['info'][]=array('fieldId'=>'login-password','message'=>'Password is incorrect!');
                    }else{
                        if($user['status'] == 1 || $user['status'] == 2){
                            $response['error']=1;
                            $response['info'][]=array('fieldId'=>'login-mail','message'=>'This account disabled or not verified!');
                        }else{
                            $response['error']=0;
                            $response['info'][]=array('fieldId'=>'submit','message'=>'Login successful');
                            $response['id'] = $user['user_id'];



                            $user_data = array(
                                'login_time' => date('Y-m-d H:i:s'),
                                'user_email' => $user['user_email'],
                                'user_name' => $user['user_name'],
                                'user_id'   => $user['user_id'],
                                'logged_in' => true,
                            );

                            $this->session->set('login_data',$user_data);
                        }
                    }
                }
            }

            print json_encode($response);

        }else{
            return view('frontend/header')
                .view('frontend/layouts/login')
                .view('frontend/footer');
        }
    }

    public function logout(){
        $this->session->destroy();

        return redirect()->route('/');
    }

}
