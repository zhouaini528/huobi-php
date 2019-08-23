<?php


/**
 * @author lin <465382251@qq.com>
 * 
 * Fill in your key and secret and pass can be directly run
 * 
 * Most of them are unfinished and need your help
 * https://github.com/zhouaini528/huobi-php.git
 * */
use Lin\Huobi\HuobiSpot;

require __DIR__ .'../../../vendor/autoload.php';

include 'key_secret.php';

$huobi=new HuobiSpot($key,$secret);

//You can set special needs
$huobi->setOptions([
    //Set the request timeout to 60 seconds by default
    'timeout'=>10,
    
    //If you are developing locally and need an agent, you can set this
    'proxy'=>true,
    //More flexible Settings
    /* 'proxy'=>[
     'http'  => 'http://127.0.0.1:12333',
     'https' => 'http://127.0.0.1:12333',
     'no'    =>  ['.cn']
     ], */
    //Close the certificate
    //'verify'=>false,
]);


//get the status of an account
try {
    $result=$huobi->account()->get();
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}

//Get the balance of an account
try {
    $result=$huobi->account()->getBalance([
        'account-id'=>$result['data'][0]['id']
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}

