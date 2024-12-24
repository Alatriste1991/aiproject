<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class AdminFeedback extends AdminBaseController
{

    private $FeedbackModel = '';

    public function __construct()
    {
        $this->adminUser = new \App\Models\AdminUser();
        $this->FeedbackModel =  new \App\Models\AdminFeedbackModel();
    }


    public function index(){

        $data = array(
            'user_name'     => $_SESSION['admin_data']['admin_name'],
            'breadcrumbs'   => array(0 => 'Műszerfal',1 => 'Feedback'),
            'page_name'     => 'Feedback lista',
        );

        $request = service('request');

        $pager = service('pager');
        $page = (@$_GET['page']) ? $_GET['page'] : 1;
        $perPage=10;
        $offset = ($page-1) * $perPage;
        $allGetData = $request->getGet();

        if(!empty($allGetData)){
            $pagination = $this->FeedbackModel->FeedbackPagination($perPage,$offset,$allGetData);
        }else{
            $pagination = $this->FeedbackModel->FeedbackPagination($perPage,$offset);
        }

        $data_index['feedbacks'] = $pagination['feedbacks'];
        $data_index['links'] = $pager->makeLinks($page,$perPage,$pagination['total'],'admin_custom_view');
        $data_index['total'] = $pagination['total'];

        foreach ($allGetData as $key => $value){

            if($value != ''){
                $data[$key] = $value;
            }
        }

        return view('admin/header', $this->header_data())
            .view('admin/sidebar',$data)
            .view('admin/layouts/feedback/index',$data_index)
            .view('admin/footer',$this->footer_data());
    }

    public function feedback($id){

        $data = array(
            'user_name'     => $_SESSION['admin_data']['admin_name'],
            'breadcrumbs'   => array(0 => 'Műszerfal',1 => 'Feedback'),
            'page_name'     => 'Feedback',
        );

        $feedback_data = $this->FeedbackModel->getFeedback($id);

        return view('admin/header', $this->header_data())
            .view('admin/sidebar',$data)
            .view('admin/layouts/feedback/check',$feedback_data[0])
            .view('admin/footer',$this->footer_data());
    }
}
