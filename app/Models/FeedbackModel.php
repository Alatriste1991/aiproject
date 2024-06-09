<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Class UserModel
 * @package App\Models
 */
class FeedbackModel extends Model
{
    protected $db = '';

    public function __construct(ConnectionInterface $db = null, ValidationInterface $validation = null)
    {
        $this->db = \Config\Database::connect();
    }

    function addFeedback($data){

        $builder = $this->db->table('feedback');

        $builder->insert($data,true);
    }
}
