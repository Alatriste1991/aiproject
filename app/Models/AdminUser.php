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
}
