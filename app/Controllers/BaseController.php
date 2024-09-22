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
abstract class BaseController extends Controller
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

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['base'];

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
        $this->activityCheck();

    }

    public function is_logged_in()
    {

        $url = (string) current_url(true);

        if(!isset($_SESSION['login_data']) && !str_contains($url, 'verification') && !str_contains($url, 'registration') && !str_contains($url, 'login') && $url != base_url().'index.php/') {
            header("Location: /login"); die();
        }

    }

    public function activityCheck(){
        if(isset($_SESSION['login_data'])) {
            if (isset($_SESSION['login_data']['last_load_time']) && (time() - $_SESSION['login_data']['last_load_time'] > 1800)) { //1800

                session_unset();
                session_destroy();
                header("Location: /login");
                die();
            }
            $_SESSION['login_data']['last_load_time'] = time();
        }

    }
}
