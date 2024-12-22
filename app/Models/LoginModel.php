<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

class LoginModel extends Model {

    protected $db = '';

    public  function __construct(ConnectionInterface $db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);

        $this->db   = \Config\Database::connect();
    }

    function info($where,$userinfo,$info,$user = ''){

        $builder = $this->db->table('logs');

        $data = array(
            'type'      => 'info',
            'process'    => $where,
            'user'      => $user,
            'ip'        => $userinfo['ip_address'],
            'browser'   => $userinfo['browser'],
            'platform'  => $userinfo['platform'],
            'info'      => $info,
            'date'      => date('Y-m-d H:i:s')
        );

        $builder->insert($data,true);
    }

    function warning($where,$userinfo,$info,$user = ''){

        $builder = $this->db->table('logs');

        $data = array(
            'type'      => 'warning',
            'process'    => $where,
            'user'      => $user,
            'ip'        => $userinfo['ip_address'],
            'browser'   => $userinfo['browser'],
            'platform'  => $userinfo['platform'],
            'info'      => $info,
            'date'      => date('Y-m-d H:i:s')
        );

        $builder->insert($data,true);
    }

    function error($where,$userinfo,$info,$user = ''){

        $builder = $this->db->table('logs');

        $data = array(
            'type'      => 'error',
            'process'    => $where,
            'user'      => $user,
            'ip'        => $userinfo['ip_address'],
            'browser'   => $userinfo['browser'],
            'platform'  => $userinfo['platform'],
            'info'      => $info,
            'date'      => date('Y-m-d H:i:s')
        );

        $builder->insert($data,true);
    }
}