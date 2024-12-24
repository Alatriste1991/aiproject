<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

/**
 * Class UserModel
 * @package App\Models
 */
class BugModel extends Model
{

    protected $db = '';

    public function __construct(ConnectionInterface $db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);

        $this->db = \Config\Database::connect();
    }

    function saveBugProject($data){

       if(isset($data['feedback_id'])){
           $feedback_id = $data['feedback_id'];
           unset($data['feedback_id']);
       }
    var_dump($data);exit;
        $builder = $this->db->table('bugs');
        $builder->insert($data,true);
        $id =  $this->db->insertID();

        $builder = $this->db->table('feedback');
        $builder->set(['bug_report_seen' => 1]);
        $builder->where('feedback_id', $feedback_id);
        $builder->update();

        return $id;
    }

}