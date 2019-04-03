<?php


/**
 * @author lin <465382251@qq.com>
 * 
 * Fill in your key and secret and pass can be directly run
 * 
 * Most of them are unfinished and need your help
 * https://github.com/zhouaini528/okex-php.git
 * */
use Lin\Huobi\HuobiFuture;

require __DIR__ .'../../../vendor/autoload.php';

include 'key_secret.php';

$huobi=new HuobiFuture();

//The Last Trade of a Contract
try {
    $result=$huobi->market()->getTrade([
        'symbol'=>'BTC_CQ'
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}

//Request a Batch of Trade Records of a Contract
try {
    $result=$huobi->market()->getHistoryTrade([
        'symbol'=>'BTC_CQ',
        //'size'=>100
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}

//Get Market Depth
try {
    $result=$huobi->market()->getDepth([
        'symbol'=>'BTC_CQ',
        'type'=>'step1'
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}



