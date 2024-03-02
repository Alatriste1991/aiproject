<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{



    protected $table = 'users';

    protected $allowedFields = ['user_id', 'user_email','user_name','password','status','created_time'];

    function getUser($params){

        $data = $this->where($params)->findAll();

        if(!empty($data)){

            return $data[0];

        }else{

            return false;

        }
    }

    function addUser($data){

        return $this->insert($data,true);
    }
}
