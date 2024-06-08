<?php

namespace App\Controllers;

/**
 * Class Package
 * @package App\Controllers
 */
class Package extends BaseController
{
    /**
     * @var array|bool|\CodeIgniter\Session\Session|float|int|object|string|null
     */
    private $session = '';

    /**
     * @var string
     */
    private $user_id = '';

    /**
     * @var \App\Models\PackageModel|string
     */
    private $packageModel = '';

    /**
     * @var \App\Models\OrderModel|string
     */
    private $orderModel = '';

    /**
     * @var \App\Models\userModel|string
     */
    private $userModel = '';

    /**
     * Package constructor.
     */
    function __construct()
    {
        $this->session = session();
        $this->user_id = $this->session->get('login_data')['user_id'];
        $this->packageModel = new \App\Models\PackageModel();
        $this->orderModel = new \App\Models\OrderModel();
        $this->userModel = new \App\Models\userModel();
    }

    /**
     * @return string
     */
    public function packages(){


        $data['packages'] = $this->packageModel->getPackages();


        return view('frontend/header')
            .view('frontend/layouts/packages/packages',$data)
            .view('frontend/footer');
    }

    /**
     * @param $id
     * @return string
     */
    public function get_package($id){

        $billing_addresses = $this->userModel->geUserAddresses($this->user_id);


        //TODO: ideiglenes, míg ingyenes csomagok vannak
        if($id == '1' && $this->checkOrder($this->user_id,$id) != false){
            $data['message'] = 'You have already got free package!';

            return view('frontend/header')
                .view('frontend/layouts/profile',$data)
                .view('frontend/footer');
        }else{
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

    }

    public function checkOrder($user_id,$id){

        $params = array(
            'user_id'       => $user_id,
            'order_p_package_id'    => $id
        );

        $order = $this->orderModel->getOrder($params);

        return $order;

    }

    /**
     *
     */
    public function select_addresses(){

        if($this->request->isAJAX()){

            $billing_address = $this->userModel->geUserAddress($_POST['id']);

            print json_encode($billing_address);
        }

    }
}