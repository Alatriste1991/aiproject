<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Class UserModel
 * @package App\Models
 */
class OrderModel extends Model
{
    /**
     * @var \CodeIgniter\Database\BaseConnection|string
     */
    protected $db = '';

    private $packageModel = '';

    /**
     * OrderModel constructor.
     * @param ConnectionInterface|null $db
     * @param ValidationInterface|null $validation
     */
    public function __construct(ConnectionInterface $db = null, ValidationInterface $validation = null)
    {
        $this->db = \Config\Database::connect();
        $this->packageModel = new \App\Models\PackageModel();
    }

    /**
     * @param int $status
     * @return array
     */
    function getPaymentMethods($status = 1){

        $builder = $this->db->table('order_payment_methods');
        if($status == 1){
            $data = $builder->getWhere(['status' => 1])->getResultArray();


        }else{
            $data = $builder->get()->getResultArray();
        }

        return $data;
    }

    /**
     * @param $data
     */
    function addOrder($data){
        $builder1 = $this->db->table('orders');

        $builder1->insert($data['order'],true);

        $data['payment_address']['order_id'] = $data['package']['order_id'] = $this->db->insertID();

        $builder2 = $this->db->table('order_payment_address');

        $builder2->insert($data['payment_address'],true);

        $builder3 = $this->db->table('order_package');

        $builder3->insert($data['package'],true);

        $package = $this->packageModel->getPackage($data['package']['order_p_package_id']);

        $this->packageModel->update_user_generating_count($data['order']['user_id'],$package['picture_qty']);

    }

    function getOrder($where){

        $builder = $this->db->table('orders');

        $builder->select('*');

        $builder->join('order_package','orders.order_id = order_package.order_id','inner');

        $data = $builder->getWhere($where)->getResultArray();

        return $data;
    }

    function OrderPagination($user_id,$perPage,$offset){

        $builder = $this->db->table('orders');
        $data['orders'] = $builder->select('*')
            ->join('order_package','orders.order_id = order_package.order_id','inner')
            ->where('user_id',$user_id)
            ->orderBy('created_time','DESC')
            ->get($perPage,$offset)
            ->getResultArray();

        $data['total'] = $builder->where('user_id',$user_id)->countAllResults();

        return $data;
    }

}