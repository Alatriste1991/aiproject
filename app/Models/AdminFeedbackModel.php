<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

/**
 * Class UserModel
 * @package App\Models
 */
class AdminFeedbackModel extends Model
{

    protected $db = '';

    public function __construct(ConnectionInterface $db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);

        $this->db      = \Config\Database::connect();
    }

    function FeedbackPagination($perPage,$offset,$where = array()){

        $builder = $this->db->table('feedback');

        unset($where['page']);
        $type = array();

        // Üres értékek eltávolítása a $where tömbből
        $where = array_filter($where, function($value) {
            return $value !== '' && !is_null($value);
        });

        if(isset($where['opinion'])){

            array_push($type,'2');
            unset( $where['opinion']);
        }
        if(isset($where['dev'])){

            array_push($type,'3');
            unset( $where['dev']);
        }
        if(isset($where['bug'])){
            array_push($type,'1');
            unset( $where['bug']);
        }

        if(isset($where['start_date']) && !isset($where['due_date']) ){
            $builder->where('created_time >=', $where['start_date'].' 00:00:00' ?? '0000-00-00');
            // Töröljük a start_date és due_date kulcsokat a $where tömbből
            unset($where['start_date']);
        }
        if(!isset($where['start_date']) && isset($where['due_date']) ){
            $builder->where('created_time <=', $where['due_date'].' 23:59:59' ?? '9999-12-31');
            // Töröljük a start_date és due_date kulcsokat a $where tömbből
            unset($where['due_date']);
        }
        if(isset($where['start_date']) && isset($where['due_date']) ){

            $builder->where('created_time >=', $where['start_date'].' 00:00:00' ?? '0000-00-00');
            $builder->where('created_time <=', $where['due_date'].' 23:59:59' ?? '9999-12-31');
            // Töröljük a start_date és due_date kulcsokat a $where tömbből
            unset($where['start_date'], $where['due_date']);
        }


        // Alapvető lekérdezés összeállítása
        $baseQuery = $builder->select('*');

        if(!isset($where['bug_report_seen'])){
            $where['bug_report_seen'] = 0;
        }


        if (!empty($where)) {
            $baseQuery->where($where);
        }

        if (!empty($type)) {
            $baseQuery->whereIn('feedback_type', $type);
        }
        // Számolás végrehajtása
        $data['total'] = $baseQuery->countAllResults(false);

        // Eredmények lekérése
        $data['feedbacks'] = $baseQuery->orderBy('created_time', 'DESC')
            ->get($perPage, $offset)
            ->getResultArray();

        return $data;
    }

    function getFeedback($id){

        return $builder = $this->db->table('feedback')
            ->select('feedback_id,feedback_type,feedback_text,feedback.created_time,feedback.user_id,
                    user_name,user_email')
            ->join('users','users.user_id = feedback.user_id','inner')
            ->where('feedback_id',$id)
            ->get()
            ->getResultArray();

    }
}