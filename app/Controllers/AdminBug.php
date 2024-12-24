<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class AdminBug extends AdminBaseController
{

    private $FeedbackModel = '';

    private $BugModel = '';

    private $adminUserModel = '';

    public function __construct()
    {
        $this->adminUser = new \App\Models\AdminUser();
        $this->FeedbackModel =  new \App\Models\AdminFeedbackModel();
        $this->adminUserModel = new \App\Models\AdminUser();
        $this->BugModel = new \App\Models\BugModel();
    }



    public function create(){

        $request = service('request');


        if($this->request->isAJAX()){

            $data = $request->getPost();

            $response = array();

            if(!isset($data['bug_name']) || $data['bug_name'] == ''){
                $response['error'] = 1;
                $response['errors']['bug_name']['index_class'] = '.form-group';
                $response['errors']['bug_name']['text'] = 'Bug megnevezése kötelező!';
            }

            if(!isset($data['bug_description']) || $data['bug_description'] == ''){
                $response['error'] = 1;
                $response['errors']['bug_description']['index_class'] = '.form-group';
                $response['errors']['bug_description']['text'] = 'Bug leírás megadása kötelező!';
            }

            if(!isset($data['priority']) || $data['priority'] == ''){
                $response['error'] = 1;
                $response['errors']['priority']['index_class'] = '.form-control';
                $response['errors']['priority']['text'] = 'Prioritás megadása kötelező!';
            }

            if(!isset($data['status']) || $data['status'] == ''){
                $response['error'] = 1;
                $response['errors']['status']['index_class'] = '.form-control';
                $response['errors']['status']['text'] = 'Státusz megadása kötelező!';
            }

            if(!isset($data['assigned_user_id']) || $data['assigned_user_id'] == ''){
                $response['error'] = 1;
                $response['errors']['assigned_user_id']['index_class'] = '.form-control';
                $response['errors']['assigned_user_id']['text'] = 'Felelős megadása kötelező!';
            }
            if(!isset($response['error'])){

                $result = $this->BugModel->saveBugProject($data);

                if($result){
                    $response['error'] = 0;
                    $response['id'] = $result;
                }
            }
            return $this->response->setJSON($response);

        }else{

            $data = array(
                'user_name'     => $_SESSION['admin_data']['admin_name'],
                'breadcrumbs'   => array(0 => 'Műszerfal',1 => 'Bug projekt létrehozása'),
                'page_name'     => 'Bug',
            );

            $allGetData = $request->getGet();

            if(!empty($allGetData)){
                $feedback_data = $this->FeedbackModel->getFeedback($allGetData['feedback_id'])[0];
                $allGetData['feedback_data'] = $feedback_data;

                if($feedback_data['bug_report_seen'] == 1){
                    $inactive_data = array(
                        'errormsg' => 'Ez a feedback már nem hozható létre újra',
                        'url'      => '/admin/bugs',
                    );
                    return view('admin/header', $this->header_data())
                        .view('admin/sidebar',$data)
                        .view('admin/layouts/custom/inactive',$inactive_data)
                        .view('admin/footer',$this->footer_data());
                }
            }

            $admins = $this->adminUserModel->getAllUser();

            $allGetData['admins'] = $admins;

            return view('admin/header', $this->header_data())
                .view('admin/sidebar',$data)
                .view('admin/layouts/bug/create',$allGetData)
                .view('admin/footer',$this->footer_data());
        }

    }
}
