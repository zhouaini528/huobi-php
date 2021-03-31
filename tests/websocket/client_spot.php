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

include 'key_secret.php';

$huobi=new HuobiWebSocket();

$huobi->config([
    //Do you want to enable local logging,default false
    //'log'=>true,
    //Or set the log name
    'log'=>['filename'=>'spot'],

    //Daemons address and port,default 0.0.0.0:2211
    //'global'=>'127.0.0.1:2211',

    //Channel subscription monitoring time,2 seconds
    //'listen_time'=>2,

    //Channel data update time,0.1 seconds
    //'data_time'=>0.1,

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

$action=intval($_GET['action'] ?? 0);//http pattern
if(empty($action)) $action=intval($argv[1]);//cli pattern

switch ($action){
    //**************public
    //subscribe
    case 1:{
        $huobi->subscribe([
            'market.btcusdt.depth.step0',
            'market.bchusdt.depth.step0',
        ]);
        break;
    }

    //unsubscribe
    case 2:{
        $huobi->unsubscribe([
            'market.btcusdt.depth.step0',
            'market.bchusdt.depth.step0',
        ]);

        break;
    }

    case 3:{

        $huobi->subscribe([
            'market.btcusdt.kline.1min',
            'market.btcusdt.bbo',
            'market.btcusdt.trade.detail',
            'market.btcusdt.detail',
            'market.btcusdt.etp',
        ]);

        break;
    }

    case 4:{
        $huobi->unsubscribe([
            'market.btcusdt.kline.1min',
            'market.btcusdt.bbo',
            'market.btcusdt.trade.detail',
            'market.btcusdt.detail',
            'market.btcusdt.etp',
        ]);

        break;
    }

    //**************private
    //subscribe
    case 10:{
        /*
        $huobi->keysecret([
            'key'=>'xxxxxxxxx',
            'secret'=>'xxxxxxxxx',
        ]);
        */
        $huobi->keysecret($key_secret[0]);
        $huobi->subscribe([
            //market
            'market.btcusdt.depth.step0',
            'market.bchusdt.depth.step0',

            //private
            'orders#btcusdt',
            'trade.clearing#btcusdt#1',
            'accounts.update#1',
        ]);

        break;
    }

    //unsubscribe
    case 11:{
        $huobi->keysecret($key_secret[0]);

        $huobi->unsubscribe([
            //market
            'market.btcusdt.depth.step0',
            'market.bchusdt.depth.step0',

            //private
            'orders#btcusdt',
            'trade.clearing#btcusdt#1',
            'accounts.update#1',
        ]);

        break;
    }



    case 20:{
        //****Three ways to get all data

        //The first way
        $huobi->keysecret($key_secret[0]);
        $data=$huobi->getSubscribes();
        print_r(json_encode($data));
        die;
        //The second way callback
        $huobi->getSubscribes(function($data){
            print_r(json_encode($data));
        });

        //The third way is to guard the process
        $huobi->getSubscribes(function($data){
            print_r(json_encode($data));
        },true);

        break;
    }

    case 21:{
        //****Three ways return to the specified channel data

        //The first way
        $data=$huobi->getSubscribe([
            'market.btcusdt.depth.step0',
            'market.bchusdt.depth.step0',
        ]);

        //The second way callback
        $huobi->getSubscribe([
            'market.btcusdt.depth.step0',
            'market.bchusdt.depth.step0',
        ],function($data){
            print_r(json_encode($data));
        });

        //The third way is to guard the process
        $huobi->getSubscribe([
            'market.btcusdt.depth.step0',
            'market.bchusdt.depth.step0',
        ],function($data){
            print_r(json_encode($data));
        },true);

        break;
    }

    case 22:{
        //****Three ways return to the specified channel data,All private data is also returned by default

        //The first way
        $huobi->keysecret($key_secret[0]);
        $data=$huobi->getSubscribe([
            'market.btcusdt.depth.step0',
            'market.bchusdt.depth.step0',
        ]);
        print_r(json_encode($data));

        //The second way callback
        $huobi->keysecret($key_secret[0]);
        $huobi->getSubscribe([
            'market.btcusdt.depth.step0',
            'market.bchusdt.depth.step0',
        ],function($data){
            print_r(json_encode($data));
        });

        //The third way is to guard the process
        $huobi->keysecret($key_secret[0]);
        $huobi->getSubscribe([
            'market.btcusdt.depth.step0',
            'market.bchusdt.depth.step0',
        ],function($data){
            print_r(json_encode($data));
        },true);

        break;
    }

    case 99:{
        $huobi->client()->test();
        break;
    }

    case 10004:{
        $huobi->client()->test2();
        break;
    }

    case 10005:{
        $huobi->client()->test_reconnection();
        break;
    }

    case 10006:{
        $huobi->client()->test_reconnection2();
        break;
    }
}


