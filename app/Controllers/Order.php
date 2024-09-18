<?php

namespace App\Controllers;

/**
 * Class Order
 * @package App\Controllers
 */
class Order extends BaseController {

    /**
     * @var array|bool|\CodeIgniter\Session\Session|float|int|object|string|null
     */
    private $session = '';

    private $user_id = '';

    private $packageModel = '';

    private $userModel = '';

    private $orderModel = '';

    protected $db = '';

    function __construct()
    {
        $this->session = session();
        $this->is_logged_in();
        $this->user_id = $this->session->get('login_data')['user_id'];
        $this->packageModel = new \App\Models\PackageModel();
        $this->orderModel = new \App\Models\OrderModel();
        $this->userModel = new \App\Models\userModel();
        $this->db = \Config\Database::connect();
    }

    public function add_order(){

        $response = array('error'=>0,'info'=>null);

        $values = array(
            'buy-package-id'                => $_POST['buy-package-id'],
            'buy-package-name'              => $_POST['buy-package-name'],
            'buy-package-country'           => $_POST['buy-package-country'],
            'buy-package-county'            => $_POST['buy-package-county'],
            'buy-package-code'              => $_POST['buy-package-code'],
            'buy-package-city'              => $_POST['buy-package-city'],
            'buy-package-address'           => $_POST['buy-package-address'],
            'buy-package-payment-method'    => $_POST['buy-package-payment-method'],
        );

        foreach ($values as $key => $value){
            if($value == ''){
                $response['error'] = 1;
                $response['info'][]=array('fieldId'=> $key,'message'=>'Please fill this field!');

            }
        }

        if($response['error'] == 0){

            $package = $this->packageModel->getPackage($values['buy-package-id']);

            $data = array(
                'order' => array(
                    'user_id'           => $this->user_id,
                    'status'            => 1,
                    'payment_method'    => $values['buy-package-payment-method'],
                    'created_time'      => date('Y-m-d H:i:s'),
                ),
                'payment_address' => array(
                    'order_payment_name'        => $values['buy-package-name'],
                    'order_payment_country'     => $values['buy-package-country'],
                    'order_payment_county'      => $values['buy-package-county'],
                    'order_payment_code'        => $values['buy-package-code'],
                    'order_payment_city'        => $values['buy-package-city'],
                    'order_payment_address'     => $values['buy-package-address'],
                ),
                'package' => array(
                    'order_p_package_id'    => $package['package_id'],
                    'order_package_name'  => $package['package_name'],
                    'order_package_price' => $package['package_price'],
                    'order_picture_qty'   => $package['picture_qty'],
                ),
            );

            $this->orderModel->addOrder($data);

            $response['info'][]=array('fieldId'=>'submit','message'=>'Billing address successfully added');
            $response['id'] = $this->user_id;
        }

        print json_encode($response);
    }

    public function order_history($user_id){

        $pager = service('pager');
        $this->db->connect();
        $page = (@$_GET['page']) ? $_GET['page'] : 1;
        $perPage=10;
        $offset = ($page-1) * $perPage;
        $builder = $this->db->table('orders');
        $data['orders'] = $builder->select('*')
            ->join('order_package','orders.order_id = order_package.order_id','inner')
            ->where('user_id',$user_id)
            ->orderBy('created_time','DESC')
            ->get($perPage,$offset)
            ->getResultArray();

        $total = $builder->where('user_id',$user_id)->countAllResults();
        $data['links'] = $pager->makeLinks($page,$perPage,$total,'custom_view');

        return view('frontend/header')
            .view('frontend/layouts/order/order_history', $data)
            .view('frontend/footer');

    }
}