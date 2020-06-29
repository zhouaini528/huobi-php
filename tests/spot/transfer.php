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


try {
    $result=$huobi->account()->postFuturesTransfer([
        //currency	string	true	NA	币种, e.g. btc
        //amount	decimal	true	NA	划转数量
        //type	string	true	NA	划转类型	从合约账户到现货账户：“futures-to-pro”，从现货账户到合约账户： “pro-to-futures”
        'currency'=>'btc',
        'amount'=>'0.001',
        'type'=>'pro-to-futures'
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}




