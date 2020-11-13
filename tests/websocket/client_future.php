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
    'log'=>['filename'=>'future'],

    //Daemons address and port,default 0.0.0.0:2211
    //'global'=>'127.0.0.1:2211',

    //Channel subscription monitoring time,2 seconds
    //'listen_time'=>2,

    //Channel data update time,default 0.5 seconds
    //'data_time'=>0.5,

    //Set up subscription platform, default 'spot'
    'platform'=>'future', //options value 'spot' 'future' 'swap' 'linear' 'option'
    //or set
    /*'platform'=>[
        'type'=>'spot',
        'market'=>'wss://api.huobi.pro/ws',
        'order'=>'wss://api.huobi.pro/ws/v2',
    ],*/
]);

$action=intval($_GET['action'] ?? 0);//http pattern
if(empty($action)) $action=intval($argv[1]);//cli pattern

switch ($action){
    //**************public
    //subscribe
    case 1:{
        $huobi->subscribe([
            'market.BTC_CQ.depth.step0',
            'market.ETH_CQ.depth.step0',
        ]);
        break;
    }

    //unsubscribe
    case 2:{
        $huobi->unsubscribe([
            'market.BTC_CQ.depth.step0',
            'market.ETH_CQ.depth.step0',
        ]);

        break;
    }

    case 3:{

        $huobi->subscribe([
            'market.BTC_CQ.kline.1min',
            'market.BTC_CQ.bbo',
            'market.BTC_CQ.trade.detail',
            'market.BTC_CQ.detail',
        ]);

        break;
    }

    case 4:{
        $huobi->unsubscribe([
            'market.BTC_CQ.kline.1min',
            'market.BTC_CQ.bbo',
            //'btcusdt@kline_1d',
            //'btcusdt@depth20'
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
            //public
            /*'market.BTC_CQ.depth.step0',
            'market.ETH_CQ.depth.step0',*/

            //private
            /*'orders.btc',
            'accounts.btc',
            'positions.btc',
            'trigger_order.BTC'*/

            'accounts.eos',
        ]);

        break;
    }

    //unsubscribe
    case 11:{
        $huobi->keysecret($key_secret[0]);

        $huobi->unsubscribe();

        break;
    }

    case 12:{
        $huobi->keysecret($key_secret[0]);
        //Subscribe to all private channels by default
        $huobi->subscribe([
            'btcusdt@depth',
            'bchusdt@depth',
        ]);

        break;
    }



    case 20:{
        //****Three ways to get all data

        //The first way
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
            'btcusdt@depth',
            'bchusdt@depth',
        ]);

        //The second way callback
        $huobi->getSubscribe([
            'btcusdt@depth',
            'bchusdt@depth',
        ],function($data){
            print_r(json_encode($data));
        });

        //The third way is to guard the process
        $huobi->getSubscribe([
            'btcusdt@depth',
            'bchusdt@depth',
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
            'orders.btc',
            'accounts.btc',
            'accounts.usdt',
            'positions.btc',
            'trigger_order.BTC'
        ]);
        print_r(json_encode($data));
        die;
        //The second way callback
        $huobi->keysecret($key_secret[0]);
        $huobi->getSubscribe([
            'btcusdt@depth',
            'bchusdt@depth',
        ],function($data){
            print_r(json_encode($data));
        });

        //The third way is to guard the process
        $huobi->keysecret($key_secret[0]);
        $huobi->getSubscribe([
            'btcusdt@depth',
            'bchusdt@depth',
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
        $huobi->keysecret($key_secret[1]);
        $huobi->subscribe();
        break;
    }

    //subscribe
    case 10006:{
        $huobi->keysecret($key_secret[0]);
        $huobi->subscribe();
        break;
    }
}


