<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Class UserModel
 * @package App\Models
 */
class UserModel extends Model
{

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $allowedFields = ['user_id', 'user_email','user_name','password','status','created_time'];

    /**
     * @param $params
     * @return bool
     */
    function getUser($params){

        $data = $this->where($params)->findAll();

        if(!empty($data)){

            return $data[0];

        }else{

            return false;

        }
    }

    /**
     * @param $data
     * @return bool|int|string
     * @throws \ReflectionException
     */
    function addUser($data){

        return $this->insert($data,true);
    }

    /**
     * @param $id
     * @return mixed
     */
    function geUserAddress($id){
        $db      = \Config\Database::connect();

        $builder = $db->table('user_billing_data');

        $data = $builder->getWhere(['billing_data_id' => $id])->getResultArray();

        return $data[0];
    }

    /**
     * @param $id
     * @return array|bool
     */
    function geUserAddresses($id){
        $db      = \Config\Database::connect();

        $builder = $db->table('user_billing_data');

        $data = $builder->getWhere(['user_id' => $id])->getResultArray();

        if(!empty($data)){

            return $data;

        }else{

            return false;

        }
    }

    /**
     * @param $data
     * @return bool|\CodeIgniter\Database\BaseResult|\CodeIgniter\Database\Query
     */
    function addUserBillingAddress($data){
        $db      = \Config\Database::connect();

        $builder = $db->table('user_billing_data');

        if($data['default'] == 1){
            $builder->set('default',0);
            $builder->where('user_id', $data['user_id']);
            $builder->update();
        }


        return $builder->insert($data);
    }

    /**
     * @param $data
     * @param $id
     */
    function editUserBillingAddress($data, $id){
        $db      = \Config\Database::connect();

        $builder = $db->table('user_billing_data');

        if($data['default'] == 1){
            $builder->set('default',0);
            $builder->where('user_id', $data['user_id']);
            $builder->update();
        }

        $builder->update($data, 'billing_data_id = '.$id);
    }

    /**
     * @param $id
     */
    function removeUserBillingAddress($id){
        $db      = \Config\Database::connect();

        $builder = $db->table('user_billing_data');

        $builder->where('billing_data_id', $id);
        $builder->delete();
    }
}
