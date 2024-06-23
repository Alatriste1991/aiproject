<?php


namespace App\Controllers;

use CodeIgniter\Controller;

class AdminHome extends AdminBaseController
{
    private $adminUser = '';

    public function __construct()
    {
        $this->adminUser = new \App\Models\AdminUser();
    }

    public function dashboard()
    {

        $data = array(
            'user_name'     => $_SESSION['admin_data']['admin_name'],
            'breadcrumbs'   => array(0 => 'Műszerfal'),
            'page_name'     => 'Műszerfal',

        );
        return view('admin/header', $this->header_data())
            .view('admin/sidebar',$data)
            .view('admin/layouts/dashboard')
            .view('admin/footer',$this->footer_data());
    }

    public function admins(){

        $admins = $this->adminUser->getAllUser();

        $data = array(
            'user_name'     => $_SESSION['admin_data']['admin_name'],
            'breadcrumbs'   => array(0 => 'Műszerfal',1 => 'Adminok'),
            'page_name'     => 'Adminok listája',
            'admins'         => $admins
        );
        return view('admin/header', $this->header_data())
            .view('admin/sidebar',$data)
            .view('admin/layouts/admins/index')
            .view('admin/footer',$this->footer_data());
    }

}