<?php


/**
 * @author lin <465382251@qq.com>
 *
 * Fill in your key and secret and pass can be directly run
 *
 * Most of them are unfinished and need your help
 * https://github.com/zhouaini528/okex-php.git
 * */
use \Lin\Huobi\HuobiWebSocket;

require __DIR__ .'../../../vendor/autoload.php';

$Huobi=new HuobiWebSocket();

$Huobi->config([
    //Do you want to enable local logging,default false
    //'log'=>true,
    //Or set the log name
    'log'=>['filename'=>'linear'],

    //Daemons address and port,default 0.0.0.0:2211
    //'global'=>'127.0.0.1:2211',

    //Channel data update time,default 0.5 seconds
    //'data_time'=>0.5,

    //Set up subscription platform, default 'spot'
    'platform'=>'linear', //options value 'spot' 'future' 'swap' 'linear' 'option'
    //Or you can set it like this
    /*
    'platform'=>[
        'type'=>'swap',
        'market'=>'ws://api.hbdm.com/linear-swap-ws',//Market Data Request and Subscription
        'order'=>'ws://api.hbdm.com/linear-swap-notification',//Order Push Subscription
        'kline'=>'ws://api.hbdm.com/ws_index',//Index Kline Data and Basis Data Subscription

        //'market'=>'ws://api.btcgateway.pro/linear-swap-ws',
        //'order'=>'ws://api.btcgateway.pro/linear-swap-notification',
        //'kline'=>'ws://api.btcgateway.pro/ws_index',
    ],
    */
]);

$Huobi->start();

