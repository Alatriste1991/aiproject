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

    private $email = '';
    private $LogModel = '';

    /**
     * User constructor.
     */
    function __construct()
    {
        $this->session = session();
        $this->is_logged_in();
        $this->userModel = new \App\Models\UserModel();
        $this->email = new \App\Controllers\Email();
        $this->LogModel = new \App\Models\LoginModel();
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
    public function registration()
    {
        if ($this->request->isAJAX()) {
            try {
                $log = '';
                $response = ['error' => 0, 'info' => null];

                $values = [
                    'reg-mail' => $this->request->getPost('reg-mail'),
                    'reg-username' => $this->request->getPost('reg-username'),
                    'reg-password1' => $this->request->getPost('reg-password1'),
                    'reg-password2' => $this->request->getPost('reg-password2'),
                ];

                // Email ellenőrzés
                if (!filter_var($values['reg-mail'], FILTER_VALIDATE_EMAIL)) {
                    $response['error'] = 1;
                    $response['info'][] = ['fieldId' => 'reg-mail', 'message' => 'Invalid email format!'];
                    $log .= "Registration attempt with invalid email format: '{$values['reg-mail']}' - ";
                }

                // Felhasználónév ellenőrzés
                if (empty($values['reg-username'])) {
                    $response['error'] = 1;
                    $response['info'][] = ['fieldId' => 'reg-username', 'message' => 'User name cannot be empty!'];
                    $log .= "Registration attempt with empty username - ";
                } elseif (strlen($values['reg-username']) < 3 || strlen($values['reg-username']) > 10) {
                    $response['error'] = 1;
                    $response['info'][] = ['fieldId' => 'reg-username', 'message' => 'The username must be at least three and a maximum of 10 characters!'];
                    $log .= "Registration attempt with invalid username length: '{$values['reg-username']}' - ";
                }

                // Jelszó ellenőrzés
                if (empty($values['reg-password1'])) {
                    $response['error'] = 1;
                    $response['info'][] = ['fieldId' => 'reg-password1', 'message' => 'Password cannot be empty!'];
                    $log .= "Registration attempt with empty password - ";
                } elseif (strlen($values['reg-password1']) < 9 || strlen($values['reg-password1']) > 16) {
                    $response['error'] = 1;
                    $response['info'][] = ['fieldId' => 'reg-password1', 'message' => 'The password must be at least 8 and a maximum of 15 characters!'];
                    $log .= "Registration attempt with invalid password length - ";
                } elseif (empty($values['reg-password2'])) {
                    $response['error'] = 1;
                    $response['info'][] = ['fieldId' => 'reg-password2', 'message' => 'Password confirmation cannot be empty!'];
                    $log .= "Registration attempt with empty password confirmation - ";
                } elseif ($values['reg-password1'] !== $values['reg-password2']) {
                    $response['error'] = 1;
                    $response['info'][] = ['fieldId' => 'reg-password2', 'message' => 'Two passwords do not match!'];
                    $log .= "Registration attempt with mismatched passwords - ";
                }

                if ($log !== '') {
                    $this->LogModel->info('registration', $this->userInfo, rtrim($log, ' - '));
                }

                if ($response['error'] == 0) {
                    $params = ['user_email' => $values['reg-mail']];
                    $user = $this->userModel->getUser($params);

                    if ($user !== false) {
                        $response['error'] = 1;
                        $response['info'][] = ['fieldId' => 'reg-mail', 'message' => 'This email address is already registered!'];
                        $this->LogModel->info('registration', $this->userInfo, "Registration attempt with existing email: {$values['reg-mail']}");
                    } else {
                        $data = [
                            'user_name' => $values['reg-username'],
                            'user_email' => $values['reg-mail'],
                            'password' => password_hash($values['reg-password1'], PASSWORD_DEFAULT),
                            'status' => 2,
                        ];

                        $addUser = $this->userModel->addUser($data);

                        if ($addUser === false) {
                            $response['error'] = 1;
                            $response['info'][] = ['fieldId' => 'reg-mail', 'message' => 'Registration unsuccessful!'];
                            $this->LogModel->error('registration', $this->userInfo, "Failed to add new user to database: {$values['reg-mail']}");
                        } else {
                            $packageModel = new \App\Models\PackageModel();
                            $packageModel->update_user_generating_count($addUser, 5);

                            $verification_url = $this->createVerificationUrl($addUser);
                            $body = 'Dear ' . $data['user_name'] . ',<br> If you want to finish registration process, please click this url below:<br><br>
                            <a href="' . $verification_url . '" target="_blank">CLICK</a>';

                            try {
                                $this->email->send($data['user_email'], 'AI project Verification', $body);
                                $response['error'] = 0;
                                $response['info'][] = ['fieldId' => 'submit', 'message' => 'Registration successful'];
                                $response['id'] = $addUser;
                                $this->LogModel->info('registration', $this->userInfo, "Successful registration for user: {$values['reg-mail']}");
                            } catch (\Exception $e) {
                                $response['error'] = 1;
                                $response['info'][] = ['fieldId' => 'submit', 'message' => 'Registration successful, but verification email could not be sent.'];
                                $this->LogModel->error('registration', $this->userInfo, "Failed to send verification email to: {$values['reg-mail']}. Error: " . $e->getMessage());
                            }
                        }
                    }
                }

                return $this->response->setJSON($response);
            } catch (\Exception $e) {
                $this->LogModel->error('registration', $this->userInfo, "AJAX error during registration: " . $e->getMessage());
                return $this->response->setJSON([
                    'error' => 1,
                    'info' => [['fieldId' => 'general', 'message' => 'An error occurred during registration. Please try again.']]
                ])->setStatusCode(500);
            }
        } else {
            return view('frontend/header')
                . view('frontend/layouts/registration')
                . view('frontend/footer');
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
        //var_dump($status);exit;
        $data = array();

        switch ($status){
            case 0:
                $data['message'] = 'Profile deleted!';
                break;

            case 1:
                $data['message'] = 'Profile disabled!';
                break;

            case 2:
                $data['message'] = 'Profile not verified yet!';
                break;

            case 3:
                $packageModel = new \App\Models\PackageModel();
                $data = array(
                    'menus'  => array(
                        'billing_address'        => '/billing_address/'.$id,
                        'payment_history'        => '/order_history/'.$id,
                        'generating_history'     => '/generating_history/'.$id,
                        'packages'             => '/packages',
                    ),
                    'user_name' => $this->session->get('login_data')['user_name'],
                    'user_email' => $this->session->get('login_data')['user_email'],
                    'login_time' => $this->session->get('login_data')['login_time'],
                    'generating_count' => $packageModel->get_user_generating_count($id)['count']
                );
                break;
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
                'payment_history'        => '/order_history'.$id,
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
    public function add_billing_address()
    {
        $user_id = $this->session->get('login_data')['user_id'];

        if ($this->request->isAJAX()) {
            try {

                $response = ['error' => 0, 'info' => null];
                $log = '';

                $values = [
                    'add-billing-data-name' => $this->request->getPost('add-billing-data-name'),
                    'add-billing-data-country' => $this->request->getPost('add-billing-data-country'),
                    'add-billing-data-county' => $this->request->getPost('add-billing-data-county'),
                    'add-billing-data-code' => $this->request->getPost('add-billing-data-code'),
                    'add-billing-data-city' => $this->request->getPost('add-billing-data-city'),
                    'add-billing-data-address' => $this->request->getPost('add-billing-data-address'),
                    'add-billing-data-default' => $this->request->getPost('add-billing-data-default'),
                ];

                foreach ($values as $key => $value) {
                    if ($value == '') {
                        $response['error'] = 1;
                        $response['info'][] = ['fieldId' => $key, 'message' => 'Please fill this field!'];
                        $log .= "Empty field: $key - ";
                    }
                }

                if ($log !== '') {
                    $this->LogModel->warning('add_billing_address', $this->userInfo, "Attempt to add billing address with empty fields: " . rtrim($log, ' - '),$user_id);
                }

                if ($response['error'] == 0) {
                    $data = [
                        'user_id' => $user_id,
                        'billing_name' => $values['add-billing-data-name'],
                        'billing_country' => $values['add-billing-data-country'],
                        'billing_county' => $values['add-billing-data-county'],
                        'billing_code' => $values['add-billing-data-code'],
                        'billing_city' => $values['add-billing-data-city'],
                        'billing_address' => $values['add-billing-data-address'],
                        'default' => $values['add-billing-data-default'],
                    ];

                    $result = $this->userModel->addUserBillingAddress($data);

                    if ($result) {
                        $response['info'][] = ['fieldId' => 'submit', 'message' => 'Billing address successfully added'];
                        $response['id'] = $user_id;
                        $this->LogModel->info('add_billing_address', $this->userInfo, "Billing address successfully added for user ID: $user_id",$user_id);
                    } else {
                        $response['error'] = 1;
                        $response['info'][] = ['fieldId' => 'submit', 'message' => 'Failed to add billing address'];
                        $this->LogModel->error('add_billing_address', $this->userInfo, "Failed to add billing address for user ID: $user_id",$user_id);
                    }
                }

                return $this->response->setJSON($response);
            } catch (\Exception $e) {
                $this->LogModel->error('add_billing_address', $this->userInfo, "Error during adding billing address: " . $e->getMessage(),$user_id);
                return $this->response->setJSON([
                    'error' => 1,
                    'info' => [['fieldId' => 'general', 'message' => 'An error occurred while adding the billing address. Please try again.']]
                ])->setStatusCode(500);
            }
        } else {
            return view('frontend/header')
                . view('frontend/layouts/add_billing_address')
                . view('frontend/footer');
        }
    }


    /**
     * @param $id
     * @return string
     */
    public function edit_billing_address($id)
    {
        $user_id = $this->session->get('login_data')['user_id'];

        $response = ['error' => 0, 'info' => null];
        if ($this->request->isAJAX()) {
            try {


                $log = '';

                $values = [
                    'add-billing-data-name' => $this->request->getPost('add-billing-data-name'),
                    'add-billing-data-country' => $this->request->getPost('add-billing-data-country'),
                    'add-billing-data-county' => $this->request->getPost('add-billing-data-county'),
                    'add-billing-data-code' => $this->request->getPost('add-billing-data-code'),
                    'add-billing-data-city' => $this->request->getPost('add-billing-data-city'),
                    'add-billing-data-address' => $this->request->getPost('add-billing-data-address'),
                    'add-billing-data-default' => $this->request->getPost('add-billing-data-default'),
                ];

                foreach ($values as $key => $value) {
                    if ($value == '') {
                        $response['error'] = 1;
                        $response['info'][] = ['fieldId' => $key, 'message' => 'Please fill this field!'];
                        $log .= "Empty field: $key - ";
                    }
                }

                if ($log !== '') {
                    $this->LogModel->warning('edit_billing_address', $this->userInfo, "Attempt to edit billing address with empty fields: " . rtrim($log, ' - ') . " for address ID: $id",$user_id);
                }

                if ($response['error'] == 0) {
                    $data = [
                        'user_id' => $user_id,
                        'billing_name' => $values['add-billing-data-name'],
                        'billing_country' => $values['add-billing-data-country'],
                        'billing_county' => $values['add-billing-data-county'],
                        'billing_code' => $values['add-billing-data-code'],
                        'billing_city' => $values['add-billing-data-city'],
                        'billing_address' => $values['add-billing-data-address'],
                        'default' => $values['add-billing-data-default'],
                    ];

                    $result = $this->userModel->editUserBillingAddress($data, $id);

                    if ($result) {
                        $response['info'][] = ['fieldId' => 'submit', 'message' => 'Billing address successfully updated'];
                        $response['id'] = $id;
                        $this->LogModel->info('edit_billing_address', $this->userInfo, "Billing address successfully updated for address ID: $id, user ID: $user_id",$user_id);
                    } else {
                        $response['error'] = 1;
                        $response['info'][] = ['fieldId' => 'submit', 'message' => 'Failed to update billing address'];
                        $this->LogModel->error('edit_billing_address', $this->userInfo, "Failed to update billing address for address ID: $id, user ID: $user_id",$user_id);
                    }
                }

                return $this->response->setJSON($response);
            } catch (\Exception $e) {
                $this->LogModel->error('edit_billing_address', $this->userInfo, "Error during editing billing address: " . $e->getMessage() . " for address ID: $id",$user_id);
                return $this->response->setJSON([
                    'error' => 1,
                    'info' => [['fieldId' => 'general', 'message' => 'An error occurred while updating the billing address. Please try again.']]
                ])->setStatusCode(500);
            }
        } else {
            try {
                $data['billing_address'] = $this->userModel->geUserAddress($id);
                if (!$data['billing_address']) {
                    $this->LogModel->warning('edit_billing_address', $this->userInfo, "Attempt to edit non-existent billing address with ID: $id",$user_id);
                }
                return view('frontend/header')
                    . view('frontend/layouts/edit_billing_address', $data)
                    . view('frontend/footer');
            } catch (\Exception $e) {
                $this->LogModel->error('edit_billing_address', $this->userInfo, "Error while loading billing address edit page: " . $e->getMessage() . " for address ID: $id",$user_id);
            }
        }
    }

    /**
     * @param $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete_billing_address($id)
    {
        try {
            $user_id = $this->session->get('login_data')['user_id'];

            $result = $this->userModel->removeUserBillingAddress($id);

            if ($result) {
                $this->LogModel->info('delete_billing_address', $this->userInfo, "Successfully deleted billing address. ID: $id, User ID: $user_id");
                return redirect()->to('/billing_address/' . $user_id);
            } else {
                $this->LogModel->error('delete_billing_address', $this->userInfo, "Failed to delete billing address. ID: $id, User ID: $user_id");
                return redirect()->to('/billing_address/' . $user_id);
            }
        } catch (\Exception $e) {
            $this->LogModel->error('delete_billing_address', $this->userInfo, "Error while deleting billing address: " . $e->getMessage() . ". ID: $id, User ID: $user_id");
            return redirect()->to('/billing_address/' . $user_id);
        }
    }


    public function createVerificationUrl($userid){

        $verification_id = $this->createVerificationid($userid);

        $url = base_url().'verification/'.$userid.'/'.$verification_id;

        return $url;

    }

    function createVerificationid($userid){

        $id = md5(uniqid(rand(), true));

        if($this->userModel->checkVerificationId(array('verification_id' => $id)) == false){

            $this->userModel->addVerificationId($id,$userid);

            return $id;
        }else{
            $this->createVerificationid($userid);
        }

    }

    public function verification($user_id, $verification_id)
    {
        try {
            // Ellenőrizzük a megerősítési ID-t
            if ($this->userModel->checkVerificationId(['verification_id' => $verification_id]) == true) {
                // Frissítjük a felhasználó státuszát
                $params = ['status' => 3];
                $this->userModel->editUser($params, $user_id);
                $this->LogModel->info('verification',$this->userInfo, "User {$user_id} verification successful with verification ID: {$verification_id}");

                // Töröljük a megerősítési ID-t
                $this->userModel->deleteVerificationId($verification_id);
                $this->LogModel->info('verification',$this->userInfo, "Deleted verification ID: {$verification_id} for user {$user_id}");

                return redirect()->to('/login');
            } else {
                // Ha a megerősítési ID nem aktív
                $data['message'] = 'Verification url is not active!';
                $data['resend_verification'] = base_url() . 'resendVerificationEmail/' . $user_id;

                $this->LogModel->warning('verification',$this->userInfo, "Invalid verification attempt for user {$user_id} with verification ID: {$verification_id}");

                return view('frontend/header')
                    . view('frontend/layouts/profile', $data)
                    . view('frontend/footer');
            }
        } catch (\Exception $e) {
            // Kivétel esetén logoljuk a hibát
            $this->LogModel->error('verification',$this->userInfo, "Error during verification for user {$user_id}: " . $e->getMessage());
            exit;
        }
    }


    public function verification_confirm(){

        return view('frontend/header')
            .view('frontend/layouts/users/verification_confirm')
            .view('frontend/footer');
    }

    public function resendVerificationEmail($user_id)
    {
        try {
            $params['user_id'] = $user_id;

            if ($this->userModel->checkVerificationId($params) == false) {
                $user = $this->userModel->getUser($params);

                if (!$user) {
                    $this->LogModel->error('resendVerificationEmail', $this->userInfo, "User not found for ID: $user_id");
                    return redirect()->to('/error')->with('error', 'User not found.');
                }

                $verification_url = $this->createVerificationUrl($user_id);
                $body = 'Dear ' . $user['user_name'] . ',<br> If you want to finish registration process, please click this url below:<br><br>
                <a href="' . $verification_url . '" target="_blank">CLICK</a>';

                if ($this->email->send($user['user_email'], 'AI project Verification', $body)) {
                    $this->LogModel->info('resendVerificationEmail', $this->userInfo, "Verification email resent to user ID: $user_id");
                    return redirect()->to('/verification_confirm');
                } else {
                    $this->LogModel->error('resendVerificationEmail', $this->userInfo, "Failed to send verification email to user ID: $user_id");

                }
            } else {
                $this->LogModel->info('resendVerificationEmail', $this->userInfo, "Verification already active for user ID: $user_id");
                return redirect()->to('/verification_confirm');
            }
        } catch (\Exception $e) {
            $this->LogModel->error('resendVerificationEmail', $this->userInfo, "Error in resending verification email: " . $e->getMessage());
        }
    }


}