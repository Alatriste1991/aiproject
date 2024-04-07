<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

class PackageModel extends Model
{

    protected $db = '';
    
    public function __construct(ConnectionInterface $db = null, ValidationInterface $validation = null)
    {
        $this->db = \Config\Database::connect();
    }

    function getPackages(){

        $builder = $this->db->table('packages');

        $data = $builder->getWhere(['status' => 1])->getResultArray();

        if(!empty($data)){

            return $data;

        }else{

            return false;

        }
    }

    function getPackage($id){

        $builder = $this->db->table('packages');

        $data = $builder->getWhere(['package_id' => $id])->getResultArray();

        if(!empty($data)){

            return $data[0];

        }else{

            return false;

        }
    }
    
    function get_user_generating_count($userid){

        $builder = $this->db->table('user_generating_count');

        $data = $builder->getWhere(['user_id' => $userid])->getResultArray();

        if(!empty($data)){

            return $data[0];

        }else{

            return false;

        }
    }

    function update_user_generating_count($userid,$count){

        $exist = $this->get_user_generating_count($userid);

        $builder= $this->db->table('user_generating_count');
        if($exist == false){
            $data = array(
                'user_id'   => $userid,
                'count'     => $count
            );

            $builder->insert($data,true);
        }else{
            $builder->set('count',$count);
            $builder->where('user_id', $userid);
            $builder->update();
        }
    }
}