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

    private $PackageModel = '';

    private $user_id = '';

    protected $db = '';

    /**
     * Home constructor.
     */
    function __construct()
    {
        $this->session = session();
        $this->is_logged_in();
        $this->user_id = $this->session->get('login_data')['user_id'];
        $this->ImageModel = new \App\Models\ImageModel();
        $this->PackageModel = new \App\Models\PackageModel();
        $this->db = \Config\Database::connect();
    }

    public function generation(){

        $data['accept'] = true;

        if($this->PackageModel->get_user_generating_count($this->user_id)['count'] == 0){
            $data['accept'] = false;
        }

        return view('frontend/header')
            .view('frontend/layouts/image/generation',$data)
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
                   $response['id'] = $this->ImageModel->getImage($this->user_id,$image)[0]['image'];//exit;//$image;
                   $response['url'] = base_url().'downloadImage/'.$image;
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

    public function generating_history($user_id){

        $pager = service('pager');
        $this->db->connect();
        $page = (@$_GET['page']) ? $_GET['page'] : 1;
        $perPage=10;
        $offset = ($page-1) * $perPage;
        $builder = $this->db->table('images');
        $images = $builder
            ->select('*')
            ->where('user_id',$user_id)
            ->orderBy('created_time','DESC')
            ->get($perPage,$offset)
            ->getResultArray();

        $total = $builder->where('user_id',$user_id)->countAllResults();

        $data = array(
            'data' => $images,
            'links' => $pager->makeLinks($page,$perPage,$total,'custom_view')
        );

        return view('frontend/header')
            .view('frontend/layouts/image/generating_history', $data)
            .view('frontend/footer');
    }

}