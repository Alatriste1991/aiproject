<?php

namespace App\Controllers;
use CodeIgniter\Controller;

/**
 * Class Home
 * @package App\Controllers
 */
class Home extends BaseController
{
    /**
     * @var array|bool|\CodeIgniter\Session\Session|float|int|object|string|null
     */
    private $session = '';

    private $ImageModel = array();

    private $LogModel = '';

    /**
     * Home constructor.
     */
    function __construct()
    {
        $this->session = session();
        $this->is_logged_in();
        $this->ImageModel = new \App\Models\ImageModel();

        $this->LogModel = new \App\Models\LoginModel();


    }

    /**
     * @return string
     */
    public function index(): string
    {
        if(isset($_SESSION['login_data'])){

            $data = array(
                'user_name' => $_SESSION['login_data']['user_name'],
                'user_id' => $_SESSION['login_data']['user_id'],
                'accept' => false,
            );
            return view('frontend/header')
                .view('frontend/layouts/main', $data)
                .view('frontend/footer');
        }else{

            $data = array(
              'accept' => true,
            );
            return view('frontend/header')
                .view('frontend/layouts/main',$data)
                .view('frontend/footer');
        }

    }


    /**
     * @return string
     *
     * status 0 - deleted
     * status 1 - disabled
     * status 2 - registered, but not verified
     * status 3 - registered and verified
     */
    public function login()
    {
        if ($this->request->isAJAX()) {
            try {
                $log = '';
                $error = 0;
                $model = new \App\Models\UserModel();
                $response = ['error' => 0, 'info' => null];

                $values = [
                    'login-mail' => $this->request->getPost('login-mail'),
                    'login-password' => $this->request->getPost('login-password'),
                ];

                if (!filter_var($values['login-mail'], FILTER_VALIDATE_EMAIL)) {
                    $error = 1;
                    $response['error'] = 1;
                    $response['info'][] = ['fieldId' => 'login-mail', 'message' => 'Invalid email format!'];
                    $log .= "Login attempt with invalid email format: '{$values['login-mail']}' - ";
                }

                if (empty($values['login-password'])) {
                    $error = 1;
                    $response['error'] = 1;
                    $response['info'][] = ['fieldId' => 'login-password', 'message' => 'Password cannot be empty!'];
                    $log .= "Login attempt with empty password for email: '{$values['login-mail']}'";
                }

                if($log != ''){
                    $this->LogModel->info('login', $this->userInfo, $log);
                }

                if ($error == 0) {
                    $params = ['user_email' => $values['login-mail']];
                    $user = $model->getUser($params);
                    $packageModel = new \App\Models\PackageModel();

                    if ($user === false) {
                        $response['error'] = 1;
                        $response['info'][] = ['fieldId' => 'login-password', 'message' => 'User not found'];
                        $this->LogModel->info('login', $this->userInfo, "Login attempt for non-existent user: {$values['login-mail']}");
                    } else {
                        $generating_count = $packageModel->get_user_generating_count($user['user_id']);

                        if (!password_verify($values['login-password'], $user['password'])) {
                            $response['error'] = 1;
                            $response['info'][] = ['fieldId' => 'login-password', 'message' => 'Password is incorrect!'];
                            $this->LogModel->info('login', $this->userInfo, "Login attempt with incorrect password for user: {$values['login-mail']}");
                        } elseif ($user['status'] == 1) {
                            $response['error'] = 1;
                            $response['info'][] = ['fieldId' => 'login-mail', 'message' => 'This account is disabled!'];
                            $this->LogModel->info('login', $this->userInfo, "Login attempt to disabled account: {$values['login-mail']}");
                        } else {
                            $response['error'] = 0;
                            $response['info'][] = ['fieldId' => 'submit', 'message' => 'Login successful'];
                            $response['id'] = $user['user_id'];

                            $user_data = [
                                'login_time' => date('Y-m-d H:i:s'),
                                'user_email' => $user['user_email'],
                                'user_name' => $user['user_name'],
                                'user_id' => $user['user_id'],
                                'logged_in' => true,
                                'pic_generating_count' => $generating_count['count'],
                                'last_load_time' => time()
                            ];

                            session()->set('login_data', $user_data);
                            $this->LogModel->info('login', $this->userInfo, "Successful login for user: '{$values['login-mail']}', user_id: '{$user['user_id']}'");
                        }
                    }
                }

                return $this->response->setJSON($response);
            } catch (\Exception $e) {
                $this->LogModel->error('login', $this->userInfo, "AJAX error during login: " . $e->getMessage());
                return $this->response->setJSON([
                    'error' => 1,
                    'info' => [['fieldId' => 'submit', 'message' => 'An error occurred during login. Please try again.']]
                ])->setStatusCode(500);
            }
        } else {
            return view('frontend/header')
                . view('frontend/layouts/login')
                . view('frontend/footer');
        }
    }



    /**
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function logout(){
        try {
            $user_id = $this->session->get('login_data')['user_id'];

            $this->session->destroy();
            $this->LogModel->info('logout', $this->userInfo, "Logout successfully: ",$user_id);

        }
        catch (\Exception $e){
            $this->LogModel->error('logout', $this->userInfo, "Error during logout: " . $e->getMessage(),$user_id);
        }

        return redirect()->route('/');
    }


    public function generate(){

        $response = array('error'=>0,'info'=>null);

        $values = array(
            'generation_text' => $_POST['generation_text']
        );

        if($values['generation_text'] == ''){
            $response['error']=1;
            $response['info'][]=array('fieldId'=>'generation_text','message'=>'Field required!');
        }else{

            if($this->ImageModel->validateText($values['generation_text'])){

                $image = $this->ImageModel->generateImage($values['generation_text'],$this->user_id);

                if(!isset($image['error'])){

                    $response['error'] = 0;
                    $response['info'][]=array('fieldId'=>'submit','message'=>'Generate successfull!');
                    $response['id'] = $this->ImageModel->getImage($this->user_id,$image)[0]['image'];//exit;//$image;
                    $response['url'] = base_url().'downloadImage/'.$image;
                }else{
                    $response['error'] = 1;
                    $response['info'][] = array('fieldId'=>'generation-text','message'=>$image['error']['message']);
                }
            }else{

                $response['error']=1;
                $response['info'][]=array('fieldId'=>'generation-text','message'=>'This text contains forbidden parts!');
            }
        }

        print json_encode($response);

    }

    public function test(){
        $text = "a boy is killing a girl in street";

        $ImageModel = new \App\Models\ImageModel();

        echo'<pre>';
        var_dump($text,$ImageModel->validateText($text));
        echo'</pre>';
    }

}
