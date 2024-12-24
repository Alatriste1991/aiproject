<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class AdminBaseController extends Controller
{
    private $session = '';

    /**
     * User constructor.
     */
    function __construct()
    {

    }
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    protected $userInfo;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    private $FeedbackModel = '';

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->session = session();
        $this->is_admin_logged_in();



        $this->userInfo = [
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => $this->request->getUserAgent()
        ];

        $this->userInfo['browser'] = $this->userInfo['user_agent']->getBrowser();
        $this->userInfo['browser_version'] = $this->userInfo['user_agent']->getVersion();
        $this->userInfo['platform'] = $this->userInfo['user_agent']->getPlatform();
    }

    public function header_data(){
        $this->FeedbackModel = new \App\Models\AdminFeedbackModel();
        $where = array(
            'bug'               => 1,
        );
        $feedback_data = $this->FeedbackModel->FeedbackPagination(10,0,$where);

        for($i=0;$i<count($feedback_data['feedbacks']);$i++){

            $currentTime = time();
            $elapsedSeconds = $currentTime - strtotime($feedback_data['feedbacks'][$i]['created_time']);
            $elapsedHours = round($elapsedSeconds / 3600);
            $feedback_data['feedbacks'][$i]['elapsed_time'] = $elapsedHours;
        }

        return  array(
            'bug_reports' => $feedback_data
        );
    }

    public function footer_data(){
        return  array(
            'date'      => date('Y'),
            'version'   => '0.1b',
        );
    }

    public function is_admin_logged_in()
    {

        $url = (string) current_url(true);
        //var_dump(!isset($_SESSION['admin_data']) && $url != base_url().'index.php/');exit;
        if(!isset($_SESSION['admin_data']) && $url != base_url().'index.php/' && !str_contains($url, 'login')) {
            header("Location: /admin/login"); die();
        }else{
            $this->adminactivityCheck();
        }

    }

    public function adminactivityCheck(){


        if(isset($_SESSION['admin_data'])){
            if (isset($_SESSION['admin_data']['last_load_time']) && (time() - $_SESSION['admin_data']['last_load_time'] >1800)){

                session_unset();
                session_destroy();
                header("Location: /admin/login"); die();
            }

            $_SESSION['admin_data']['last_load_time'] = time();
        }

    }
}
