<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

/**
 * Class UserModel
 * @package App\Models
 */
class AdminLogModel extends Model
{
    public function __construct(ConnectionInterface $db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);

        $this->db      = \Config\Database::connect();
    }

    function LogPagination($perPage,$offset,$where = array()){

        $builder = $this->db->table('logs');

        unset($where['page']);
        $where['type'] = array();

        foreach ($where as $key => $value){
            if($value == '' || empty($value)){
                unset($where[$key]);
            }
        }
        if(isset($where['info'])){
            if(!isset($where['type'])){
                $where['type'] = array();
            }
            array_push($where['type'],'info');
            unset( $where['info']);
        }
        if(isset($where['warning'])){
            if(!isset($where['type'])){
                $where['type'] = array();
            }
            array_push($where['type'],'warning');
            unset( $where['warning']);
        }
        if(isset($where['error'])){
            if(!isset($where['type'])){
                $where['type'] = array();
            }
            array_push($where['type'],'error');
            unset( $where['error']);
        }

        if(isset($where['start_date']) && !isset($where['due_date']) ){
            $builder->where('date >=', $where['start_date'].' 00:00:00' ?? '0000-00-00');
            // Töröljük a start_date és due_date kulcsokat a $where tömbből
            unset($where['start_date']);
        }
        if(!isset($where['start_date']) && isset($where['due_date']) ){
            $builder->where('date <=', $where['due_date'].' 23:59:59' ?? '9999-12-31');
            // Töröljük a start_date és due_date kulcsokat a $where tömbből
            unset($where['due_date']);
        }
        if(isset($where['start_date']) && isset($where['due_date']) ){
            $builder->where('date >=', $where['start_date'].' 00:00:00' ?? '0000-00-00');
            $builder->where('date <=', $where['due_date'].' 23:59:59' ?? '9999-12-31');
            // Töröljük a start_date és due_date kulcsokat a $where tömbből
            unset($where['start_date'], $where['due_date']);
        }

        // Üres értékek eltávolítása a $where tömbből
        $where = array_filter($where, function($value) {
            return $value !== '' && !is_null($value);
        });

        if(empty($where)){

            $data['logs'] = $builder->select('*')
                ->orderBy('date','DESC')
                ->get($perPage,$offset)
                ->getResultArray();

            $data['total'] = $builder->where($where)->countAllResults();
        }else{
            $data['logs'] = $builder->select('*')
              ->where($where)
              ->orderBy('date','DESC')
              ->get($perPage,$offset)
              ->getResultArray();
            $data['total'] = $builder->where($where)->countAllResults();
        }

        return $data;
    }
}