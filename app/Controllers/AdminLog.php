<?php


namespace App\Controllers;

use CodeIgniter\Controller;

class AdminLog extends AdminBaseController
{
    private $adminUser = '';

    private $AdminLogModel = '';

    public function __construct()
    {
        $this->adminUser = new \App\Models\AdminUser();
        $this->AdminLogModel = new \App\Models\AdminLogModel();
    }

    public function log(){

        $request = service('request');

        $pager = service('pager');
        $page = (@$_GET['page']) ? $_GET['page'] : 1;
        $perPage=10;
        $offset = ($page-1) * $perPage;
        $allGetData = $request->getGet();

       if(!empty($allGetData)){
           $pagination = $this->AdminLogModel->LogPagination($perPage,$offset,$allGetData);
       }else{
           $pagination = $this->AdminLogModel->LogPagination($perPage,$offset);
       }

        $data_index['logs'] = $pagination['logs'];
        $data_index['links'] = $pager->makeLinks($page,$perPage,$pagination['total'],'admin_custom_view');
        $data_index['total'] = $pagination['total'];

        $data = array(
            'user_name'     => $_SESSION['admin_data']['admin_name'],
            'breadcrumbs'   => array(0 => 'Műszerfal',1 => 'Log'),
            'page_name'     => 'Adminok listája',
        );

        foreach ($allGetData as $key => $value){

            if($value != ''){
                $data[$key] = $value;
            }
        }

        return view('admin/header', $this->header_data())
            .view('admin/sidebar',$data)
            .view('admin/layouts/log/index',$data_index)
            .view('admin/footer',$this->footer_data());
    }
}
