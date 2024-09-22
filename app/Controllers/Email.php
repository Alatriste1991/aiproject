<?php

namespace App\Controllers;
use CodeIgniter\Controller;

/**
 * Class Home
 * @package App\Controllers
 */
class Email extends BaseController
{

    public function send($to,$subject,$body){
        $email = \Config\Services::email();

        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($body);

        return $email->send();

    }

}