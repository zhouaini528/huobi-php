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
    'log'=>['filename'=>'spot'],

    //Daemons address and port,default 0.0.0.0:2211
    //'global'=>'127.0.0.1:2211',

    //Channel subscription monitoring time,2 seconds
    //'listen_time'=>2,

    //Channel data update time,default 0.5 seconds
    //'data_time'=>0.5,

    //Set up subscription platform, default 'spot'
    'platform'=>'spot', //options value 'spot' 'future' 'swap' 'linear' 'option'
    //Or you can set it like this
    /*
    'platform'=>[
        'type'=>'spot',
        'market'=>'ws://api.huobi.pro/ws',//Market Data Request and Subscription
        'order'=>'ws://api.huobi.pro/ws/v2',//Order Push Subscription

        //'market'=>'ws://api-aws.huobi.pro/ws',
        //'order'=>'ws://api-aws.huobi.pro/ws/v2',
    ],
    */
]);

$Huobi->start();

