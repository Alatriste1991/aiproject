<?php

namespace App\Controllers;
use CodeIgniter\Controller;

/**
 * Class Home
 * @package App\Controllers
 */
class Image extends BaseController
{
    /**
     * @var array|bool|\CodeIgniter\Session\Session|float|int|object|string|null
     */
    private $session = '';

    private $ImageModel = '';

    private $user_id = '';

    /**
     * Home constructor.
     */
    function __construct()
    {
        $this->session = session();
        $this->user_id = $this->session->get('login_data')['user_id'];
        $this->ImageModel = new \App\Models\ImageModel();
    }

    public function generation(){

        return view('frontend/header')
            .view('frontend/layouts/image/generation')
            .view('frontend/footer');
    }

    public function generate(){

        $response = array('error'=>0,'info'=>null);

        $values = array(
            'generation_text' => $_POST['generation_text']
        );

        if($values['generation_text'] == ''){
            $response['error']=1;
            $response['info'][]=array('fieldId'=>'generation_text','message'=>'Field required!');
        }else{

           if($this->ImageModel->validateText($values['generation_text'])){

               $image = $this->ImageModel->generateImage($values['generation_text'],$this->user_id);

               if(!isset($image['error'])){

                   $response['error'] = 0;
                   $response['info'][]=array('fieldId'=>'submit','message'=>'Generate successfull!');
                   $response['id'] = $image;
               }else{
                   $response['error'] = 1;
                   $response['info'][] = array('fieldId'=>'generation-text','message'=>$image['error']['message']);
               }
           }else{

               $response['error']=1;
               $response['info'][]=array('fieldId'=>'generation-text','message'=>'This text contains forbidden parts!');
           }
        }

        print json_encode($response);

    }

    public function image($id){

        $data = array(
            'url' => base_url().'downloadImage/'.$id);

        return view('frontend/header')
            .view('frontend/layouts/image/image', $data)
            .view('frontend/footer');
    }

    public function downloadImage($hash){

        $base_64 = $this->ImageModel->getImage($this->user_id,$hash)[0]['image'];

        if($base_64 != false){
            header("Content-type: image/jpeg");
            header("Cache-Control: no-store, no-cache");
            header('Content-Disposition: attachment; filename="'.$hash.'.jpg"');
            ob_clean();
            flush();
            echo base64_decode($base_64);

        }
    }



}