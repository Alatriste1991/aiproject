<?php

namespace App\Controllers;
use CodeIgniter\Controller;

/**
 * Class User
 * @package App\Controllers
 */
class User extends BaseController
{
    /**
     * @var array|bool|\CodeIgniter\Session\Session|float|int|object|string|null
     */
    private $session = '';
    /**
     * @var \App\Models\UserModel|string
     */
    private $userModel = '';

    /**
     * User constructor.
     */
    function __construct()
    {
        $this->session = session();
        $this->is_logged_in();
        $this->userModel = new \App\Models\UserModel();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function checkUser($id){
        $params['user_id'] = $id;

        return $this->userModel->getUser($params)['status'];


    }

    /**
     * @return string
     */
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
                    $packageModel = new \App\Models\PackageModel();
                    $packageModel->update_user_generating_count($addUser,1);

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

    /**
     * status 0 - deleted
     * status 1 - disabled
     * status 2 - registered, but not verified
     * status 3 - registered and verified
     * @param $id
     * @return string
     */
    public function profile($id){
        
        $status = $this->checkUser($id);

        $data = array();

        if($status == 2){
            $data['message'] = 'Profile not verified yet!';
        }else{
            $packageModel = new \App\Models\PackageModel();
           $data = array(
               'menus'  => array(
                   'billing_address'        => '/billing_address/'.$id,
                   'payment_history'        => '/payment_history/'.$id,
                   'generating_history'     => '/generating_history/'.$id,
                   'packages'             => '/packages',
               ),
               'user_name' => $this->session->get('login_data')['user_name'],
               'user_email' => $this->session->get('login_data')['user_email'],
               'login_time' => $this->session->get('login_data')['login_time'],
               'generating_count' => $packageModel->get_user_generating_count($id)['count']
           );
        }

        return view('frontend/header')
            .view('frontend/layouts/profile',$data)
            .view('frontend/footer');
    }

    /**
     * @param $id
     * @return string
     */
    public function billing_address($id){
        echo $id;

        $data = array(
            'menus'  => array(
                'billing_address'        => '/billing_address/'.$id,
                'payment_history'        => '/payment_history'.$id,
                'generating_history'     => '/generating_history'.$id,
                'packages'             => '/packages',
            ),
            'user_name' => $this->session->get('login_data')['user_name'],
        );

        $billing_addresses = $this->userModel->geUserAddresses($id);

        if($billing_addresses == false){
            $data['billing_addresses'] = false;
        }else{
            $data['billing_addresses'] = $billing_addresses;
        }

        return view('frontend/header')
            .view('frontend/layouts/billing_address',$data)
            .view('frontend/footer');
    }

    /**
     * @return string
     */
    public function add_billing_address(){
        $user_id = $this->session->get('login_data')['user_id'];

        $model = new \App\Models\UserModel();

        $response = array('error'=> 0,'info'=>null);

        if($this->request->isAJAX()){

            $values = array
            (
                'add-billing-data-name'	        => $_POST['add-billing-data-name'],
                'add-billing-data-country'      => $_POST['add-billing-data-country'],
                'add-billing-data-county'       => $_POST['add-billing-data-county'],
                'add-billing-data-code'         => $_POST['add-billing-data-code'],
                'add-billing-data-city'         => $_POST['add-billing-data-city'],
                'add-billing-data-address'      => $_POST['add-billing-data-address'],
                'add-billing-data-default'      => $_POST['add-billing-data-default'],
            );

            foreach ($values as $key => $value){
                if($value == ''){
                    $response['error'] = 1;
                    $response['info'][]=array('fieldId'=> $key,'message'=>'Please fill this field!');

                }
            }

            if($response['error'] == 0){
                $data = array(
                    'user_id'           => $user_id,
                    'billing_name'      => $values['add-billing-data-name'],
                    'billing_country'   => $values['add-billing-data-country'],
                    'billing_county'    => $values['add-billing-data-county'],
                    'billing_code'      => $values['add-billing-data-code'],
                    'billing_city'      => $values['add-billing-data-city'],
                    'billing_address'   => $values['add-billing-data-address'],
                    'default'           => $values['add-billing-data-default'],
                );
                $response['info'][]=array('fieldId'=>'submit','message'=>'Billing address successfully added');
                $response['id'] = $user_id;

                $this->userModel->addUserBillingAddress($data);
            }

            print json_encode($response);
        }else{
            return view('frontend/header')
                .view('frontend/layouts/add_billing_address')
                .view('frontend/footer');
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function edit_billing_address($id){

        $user_id = $this->session->get('login_data')['user_id'];

        $response = array('error'=> 0,'info'=>null);

        if($this->request->isAJAX()){

            $values = array
            (
                'add-billing-data-name'	        => $_POST['add-billing-data-name'],
                'add-billing-data-country'      => $_POST['add-billing-data-country'],
                'add-billing-data-county'       => $_POST['add-billing-data-county'],
                'add-billing-data-code'         => $_POST['add-billing-data-code'],
                'add-billing-data-city'         => $_POST['add-billing-data-city'],
                'add-billing-data-address'      => $_POST['add-billing-data-address'],
                'add-billing-data-default'      => $_POST['add-billing-data-default'],
            );

            foreach ($values as $key => $value){
                if($value == ''){
                    $response['error'] = 1;
                    $response['info'][]=array('fieldId'=> $key,'message'=>'Please fill this field!');

                }
            }

            if($response['error'] == 0){
                $data = array(
                    'user_id'           => $user_id,
                    'billing_name'      => $values['add-billing-data-name'],
                    'billing_country'   => $values['add-billing-data-country'],
                    'billing_county'    => $values['add-billing-data-county'],
                    'billing_code'      => $values['add-billing-data-code'],
                    'billing_city'      => $values['add-billing-data-city'],
                    'billing_address'   => $values['add-billing-data-address'],
                    'default'           => $values['add-billing-data-default'],
                );
                $response['info'][]=array('fieldId'=>'submit','message'=>'Billing address successfully added');
                $response['id'] = $id;

               $this->userModel->editUserBillingAddress($data,$id);
            }

            print json_encode($response);
        }else{

            $data['billing_address'] = $this->userModel->geUserAddress($id);

            return view('frontend/header')
                .view('frontend/layouts/edit_billing_address',$data)
                .view('frontend/footer');
        }
    }

    /**
     * @param $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete_billing_address($id){

        $user_id = $this->session->get('login_data')['user_id'];

        $this->userModel->removeUserBillingAddress($id);

        return redirect()->to('/billing_address/'.$user_id);
    }
}