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

    protected $db = '';

    public function __construct(ConnectionInterface $db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);

        $this->db      = \Config\Database::connect();
    }

    function LogPagination($perPage,$offset,$where = array()){

        $builder = $this->db->table('logs');

        unset($where['page']);
        $type = array();

        // Üres értékek eltávolítása a $where tömbből
        $where = array_filter($where, function($value) {
            return $value !== '' && !is_null($value);
        });


        if(isset($where['admin']) && $where['admin'] == '2'){
            unset($where['admin']);
        }

        if(isset($where['info'])){

            array_push($type,'info');
            unset( $where['info']);
        }
        if(isset($where['warning'])){

            array_push($type,'warning');
            unset( $where['warning']);
        }
        if(isset($where['error'])){
            array_push($type,'error');
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

        // Alapvető lekérdezés összeállítása
        $baseQuery = $builder->select('*');

        if (!empty($where)) {
            $baseQuery->where($where);
        }
        if (!empty($type)) {
            $baseQuery->whereIn('type', $type);
        }
        // Számolás végrehajtása
        $data['total'] = $baseQuery->countAllResults(false);

        // Eredmények lekérése
        $data['logs'] = $baseQuery->orderBy('date', 'DESC')
            ->get($perPage, $offset)
            ->getResultArray();

        return $data;
    }
}