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

    /**
     * OrderModel constructor.
     * @param ConnectionInterface|null $db
     * @param ValidationInterface|null $validation
     */
    public function __construct(ConnectionInterface $db = null, ValidationInterface $validation = null)
    {
        $this->db = \Config\Database::connect();
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

        $data['payment_address']['order_id'] = $data['package']['order_id'] = $builder1->insert($data['order'],true);

        $builder2 = $this->db->table('order_payment_address');

        $builder2->insert($data['payment_address'],true);

        $builder3 = $this->db->table('order_package');

        $builder3->insert($data['package'],true);

    }

}