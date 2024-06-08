<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Class UserModel
 * @package App\Models
 */
class ImageModel extends Model
{

    /**
     * @var \CodeIgniter\Database\BaseConnection|string
     */
    protected $db = '';

    protected $api_key = '';

    private $packageModel = '';

    private $categories = array(
        'sexual',
        'hate',
        'harassment',
        'self-harm',
        'sexual/minors',
        'hate/threatening',
        'violence/graphic',
        'self-harm/intent',
        'self-harm/instructions',
        'harassment/threatening',
        'violence',
    );

    public function __construct(ConnectionInterface $db = null, ValidationInterface $validation = null)
    {
        $this->db = \Config\Database::connect();
        $this->api_key =  env("api_key");
        $this->packageModel = new \App\Models\PackageModel();
    }

    function validateText($text){

        $post = array(
            'input' => $text,
        );

        $authorization = "Authorization: Bearer ".$this->api_key;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array('Content-Type: application/json' , $authorization ),
            CURLOPT_URL => 'https://api.openai.com/v1/moderations',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($post),
        ));

        $response = json_decode(curl_exec($curl),true);

        if($response['results'][0]['flagged'] == false){
            return true;
        }else{
            return false;
        }

    }

    function generateImage($text,$user_id){

        $post = array(
            'model'     => 'dall-e-3',
            'prompt'    => $text,
            "n"         => 1,
            "size"      => "1024x1024",
            'response_format' => 'b64_json'
        );

        $authorization = "Authorization: Bearer ".$this->api_key;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array('Content-Type: application/json' , $authorization ),
            CURLOPT_URL => 'https://api.openai.com/v1/images/generations',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($post),
        ));

        $response = json_decode(curl_exec($curl),true);

        if(isset($response['data'][0]['b64_json'])){

            $count = $this->packageModel->get_user_generating_count($user_id);

            $this->packageModel->update_user_generating_count($user_id,$count['count']-1);

            return $this->saveImage($text,$response['data'][0]['b64_json'],$user_id);

        }else{
            return $response['error'];
        }

    }

    function saveImage($text,$image,$user_id){

        $hash = $this->createImageHash();
        $data = array(
            'user_id' => $user_id,
            'image_url_id' => $hash,
            'image'   => $image,
            'prompt' => $text
        );

        $builder = $this->db->table('images');

        $builder->insert($data,true);

        return $data['image_url_id'];

    }

    function createImageHash(){
        $id = md5(uniqid(rand(), true));

        if($this->checkImageId($id) == false){

            return $id;
        }else{
            $this->createImageHash();
        }
    }

    function checkImageId($id){


        $builder = $this->db->table('images');

        $data = $builder->getWhere(['image_url_id' => $id])->getResultArray();

        if(!empty($data)){

            return true;

        }else{

            return false;

        }
    }

    function getImage($user_id,$hash){

        $builder = $this->db->table('images');

        $data = $builder->getWhere(['image_url_id' => $hash,'user_id' => $user_id])->getResultArray();

        if(!empty($data)){

            return $data;

        }else{

            return false;

        }
    }
}