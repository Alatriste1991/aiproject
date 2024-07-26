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

    public function checkadminpage(){

        if (isset($_SESSION['admin_data'])){
            header("Location: /admin/dashboard"); die();
        }else{
            header("Location: /admin/login"); die();
        }

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

    public function addUser(){

        if ($this->request->isAJAX()) {

            $error = 0;
            $response = array(
                'error' => 0,
                'email' => 0,
                'password' => 0,
                'user_name' => 0,
                'all' => 0,
                'info' => array()
            );

            $data = array(
                'admin_email' => $_POST['email'],
                'admin_name' => $_POST['user_name'],
                'admin_password' => $_POST['password'],
            );

            if (!filter_var($data['admin_email'], FILTER_VALIDATE_EMAIL)) {
                $error = 1;
                $response['error'] = 1;
                $response['email'] = 1;
                $response['info']['email'] = 'Helytelen email formátum!';
            }

            if (strlen($data['admin_name']) < 3 || strlen($data['admin_name']) > 100) {
                $error = 1;
                $response['error'] = 1;
                $response['user_name'] = 1;
                $response['info']['user_name'] = 'A név minimum 3, maximum 100 karakter lehet!';
            }

            if (preg_match('~[0-9]+~', $data['admin_name'])) {
                $error = 1;
                $response['error'] = 1;
                $response['user_name'] = 1;
                $response['info']['user_name'] = 'A név nem tartalmazhat számokat';
            }

            if (strlen($data['admin_password']) < 5 || strlen($data['admin_password']) > 20) {
                $error = 1;
                $response['error'] = 1;
                $response['password'] = 1;
                $response['info']['password'] = 'A jelszó minimum 5 és maximum 12 karakter hosszú lehet!';
            }

            $params = array(
                'admin_email' => $data['admin_email']
            );

            $user = $this->adminUser->getUser($params);

            if ($user != false) {
                $error = 1;
                $response['error'] = 1;
                $response['email'] = 1;
                $response['info']['email'] = 'Email cím már szerepel a rendszerben!';
            }

            if ($error == 1) {
                print json_encode($response);
                exit;
            } else {

                $data['admin_status'] = 1;
                $data['admin_password'] = password_hash($data['admin_password'], PASSWORD_DEFAULT);

                $addUser = $this->adminUser->addUser($data);

                if ($addUser == false) {
                    $response['error'] = 1;
                    $response['all'] = 1;
                    $response['info']['all'] = 'Sikertelen létrehozás';
                } else {
                    $response['error'] = 0;
                    $response['info']['all'] = 'Sikeresen létrehozta az admin profilt';
                }

                print json_encode($response);
                exit;
            }

        } else {

            $data = array(
                'user_name' => $_SESSION['admin_data']['admin_name'],
                'breadcrumbs' => array(0 => 'Műszerfal', 1 => 'Admin létrehozása'),
                'page_name' => 'Admin profil létrehozása',
            );
            return view('admin/header', $this->header_data())
                . view('admin/sidebar', $data)
                . view('admin/layouts/admins/create')
                . view('admin/footer', $this->footer_data());

        }
    }


    public function removeUser($id){

        $this->adminUser->removeUser($id);

        header('Location: /admin/admins?success=true'); die();

    }


    public function editUser($id){

        if ($this->request->isAJAX()) {

            $error = 0;
            $data = array(
                'admin_id'          => $_POST['admin_id'],
                'admin_name'        => $_POST['admin_name'],
                'admin_password'    => $_POST['admin_password'],
            );


            if (strlen($data['admin_name']) < 3 || strlen($data['admin_name']) > 100) {
                $error = 1;
                $response['error'] = 1;
                $response['user_name'] = 1;
                $response['info']['user_name'] = 'A név minimum 3, maximum 100 karakter lehet!';
            }

            if (preg_match('~[0-9]+~', $data['admin_name'])) {
                $error = 1;
                $response['error'] = 1;
                $response['user_name'] = 1;
                $response['info']['user_name'] = 'A név nem tartalmazhat számokat';
            }

            if($data['admin_password'] == ''){
                unset($data['admin_password']);
            }else{
                if (strlen($data['admin_password']) < 5 || strlen($data['admin_password']) > 12) {
                    $error = 1;
                    $response['error'] = 1;
                    $response['password'] = 1;
                    $response['info']['password'] = 'A jelszó minimum 5 és maximum 12 karakter hosszú lehet!';
                }
            }

            if($error == 1){
                print json_encode($response);
                exit;
            }else{
                if(isset($data['admin_password'])){
                    $data['admin_password'] = password_hash($data['admin_password'], PASSWORD_DEFAULT);
                }

                $editUser = $this->adminUser->editUser($data,$id);

                if ($editUser == false) {
                    $response['error'] = 1;
                    $response['all'] = 1;
                    $response['info']['all'] = 'Sikertelen szerkesztés';
                } else {
                    $response['error'] = 0;
                    $response['info']['all'] = 'Sikeresen szerkesztés';
                }

                print json_encode($response);
                exit;
            }
            echo'<pre>';
            var_dump($_POST);
            echo'</pre>';
        }else{

            $params = array(
                'admin_id' => $id
            );

            $user = $this->adminUser->getUser($params);

            $data = array(
                'user_name' => $user['admin_name'],
                'breadcrumbs' => array(0 => 'Műszerfal', 1 => $user['admin_name'].' profil szerkesztése'),
                'page_name' => $user['admin_name'].' profil szerkesztése',
                'user_data' => $user,
            );
            return view('admin/header', $this->header_data())
                . view('admin/sidebar', $data)
                . view('admin/layouts/admins/edit')
                . view('admin/footer', $this->footer_data());
        }
    }

}