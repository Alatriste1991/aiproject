<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

/**
 * Class UserModel
 * @package App\Models
 */
class AdminUser extends Model
{

    protected $db = '';


    public function __construct(ConnectionInterface $db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);

        $this->db      = \Config\Database::connect();
    }

    function getUser($params){

        $builder = $this->db->table('admins');

        $data = $builder->getWhere($params)->getResultArray();

        if(!empty($data)){

            return $data[0];

        }else{

            return false;

        }
    }

    function getAllUser(){
        $builder = $this->db->query('SELECT * FROM admins');

        $data = $builder->getResultArray();

        return $data;
    }

    function addUser($data){

        $builder = $this->db->table('admins');
        return $builder->insert($data,true);
    }

    function removeUser($id){

        $builder = $this->db->table('admins');

        $builder->where('admin_id', $id);
        $builder->delete();
    }

    function editUser($data,$id){

        $builder = $this->db->table('admins');

        $builder->set($data);
        $builder->where('admin_id', $id);
        return $builder->update();
    }


    /* frontUsers*/


    function getAllFrontUser(){

        $builder = $this->db->query('SELECT * FROM users');

        $data = $builder->getResultArray();

        return $data;
    }

    function generateCount(){
        $builder = $this->db->table('images');

        return $builder->countAllResults();
    }
}
