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

    function editUser($data,$user_id){
        $db      = \Config\Database::connect();

        $builder = $db->table('users');
        $builder->set($data);
        $builder->where('user_id', $user_id);
        $builder->update();
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

    function checkVerificationId($params){
        $db      = \Config\Database::connect();

        $builder = $db->table('verification_id');

        $data = $builder->getWhere($params)->getResultArray();

        if(!empty($data)){

            if(time() - strtotime($data[0]['created_time']) < 600){ //10 perc
                return true;
            } else{
                $builder->where($params)
                ->delete();
                return false;

            }

        }else{
            return false;

        }
    }

    function addVerificationId($verification_id,$userid){

        $data = array(
            'user_id'           =>  $userid,
            'verification_id'   => $verification_id
        );

        $db      = \Config\Database::connect();

        $builder = $db->table('verification_id');

        $builder->insert($data,true);
    }

    function deleteVerificationId($verification_id){
        $db      = \Config\Database::connect();

        $builder = $db->table('verification_id');

        $builder->where('verification_id', $verification_id);
        $builder->delete();
    }
}
