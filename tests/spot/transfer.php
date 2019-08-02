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

$huobi->setProxy();

//Set the request timeout to 60 seconds by default
$huobi->setTimeOut(10);

try {
    $result=$huobi->futures()->postTransfer([
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


try {
    $result=$huobi->fee()->getFeeRate([
        //symbols	string	true	NA	交易对，可多填，逗号分隔	如"btcusdt,ethusdt"
        'symbols'=>'btcusdt,ethusdt'
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}




