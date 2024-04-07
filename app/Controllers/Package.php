<?php

namespace App\Controllers;

class Package extends BaseController
{
    private $session = '';

    private $user_id = '';

    private $packageModel = '';

    private $orderModel = '';

    private $userModel = '';

    function __construct()
    {
        $this->session = session();
        $this->user_id = $this->session->get('login_data')['user_id'];
        $this->packageModel = new \App\Models\PackageModel();
        $this->orderModel = new \App\Models\OrderModel();
        $this->userModel = new \App\Models\userModel();
    }

    public function packages(){


        $data['packages'] = $this->packageModel->getPackages();


        return view('frontend/header')
            .view('frontend/layouts/packages/packages',$data)
            .view('frontend/footer');
    }

    public function get_package($id){

        $billing_addresses = $this->userModel->geUserAddresses($this->user_id);

        $data['package']            = $this->packageModel->getPackage($id);
        $data['payment_methods']    = $this->orderModel->getPaymentMethods();

        if($billing_addresses == false){
            $data['billing_addresses'] = false;
        }else{
            $data['billing_addresses'] = $billing_addresses;
        }

        return view('frontend/header')
            .view('frontend/layouts/packages/get_package',$data)
            .view('frontend/footer');

    }

    public function select_addresses(){

        if($this->request->isAJAX()){

            $billing_address = $this->userModel->geUserAddress($_POST['id']);

            print json_encode($billing_address);
        }

    }
}