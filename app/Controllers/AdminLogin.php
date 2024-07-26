<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class AdminLogin extends AdminBaseController
{

    private $session = '';

    private $adminUser = '';


    function __construct()
    {
        $this->session = session();
        $this->adminUser = new \App\Models\AdminUser();

    }

    public function login(){

        if($this->request->isAJAX()){

           $response = array(
               'error'      => 0,
               'email'      => 0,
               'password'   => 0,
               'info'       => ''
           );

           $data = array(
               'email'      => $_POST['email'],
               'password'   => $_POST['password'],
           );

           if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL)){
               $response['error'] = 1;
               $response['email'] = 1;
               $response['info'] = 'Invalid email format!';

               print json_encode($response);exit;
           }

           $params['admin_email'] = $data['email'];

           $user = $this->adminUser->getUser($params);


           if($user == false){
               $response['error'] = 1;
               $response['email'] = 1;
               $response['info'] = 'Email doesn\'t exist';

               print json_encode($response);exit;
           }else{
               if($data['admin_status'] == 0){
                   $response['error'] = 1;
                   $response['info'] = 'This profile is inactive';

                   print json_encode($response);exit;
               }else{
                   if(!password_verify($data['password'],$user['admin_password'])){
                       $response['error'] = 1;
                       $response['password'] = 1;
                       $response['info'] = 'Password is incorrect';

                       print json_encode($response);exit;
                   }else{

                       $admin_data = array(
                           'login_time'            => date('Y-m-d H:i:s'),
                           'admin_email'            => $user['admin_email'],
                           'admin_name'             => $user['admin_name'],
                           'admin_id'               => $user['admin_id'],
                           'logged_in'             => true,
                           'last_load_time'        => time()
                       );

                       $this->session->set('admin_data',$admin_data);

                       $response['error'] = 0;
                       $response['email'] = 0;
                       $response['password'] = 0;

                       print json_encode($response);exit;
                   }
               }
           }

           //

        }else{
            return view('admin/login');
        }
    }

    public function logout(){
        $this->session->destroy();

        return redirect()->route('/admin/login');
    }

}