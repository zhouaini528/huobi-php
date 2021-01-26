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

    //Channel data update time,default 0.5 seconds
    //'data_time'=>0.5,

    //Set up subscription platform, default 'spot'
    'platform'=>'future', //options value 'spot' 'future' 'swap' 'linear' 'option'
    //Or you can set it like this
    /*
    'platform'=>[
        'type'=>'future',
        'market'=>'ws://api.hbdm.com/ws',//Market Data Request and Subscription
        'order'=>'ws://api.hbdm.com/notification',//Order Push Subscription
        'kline'=>'ws://api.hbdm.com/ws_index',//Index Kline Data and Basis Data Subscription

        //'market'=>'ws://api.btcgateway.pro/ws',
        //'order'=>'ws://api.btcgateway.pro/notification',
        //'kline'=>'ws://api.btcgateway.pro/ws_index',
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
            //market
            'market.BTC_CQ.depth.step0',
            'market.ETH_CQ.depth.step0',
            //kline
            'market.BTC-USD.index.1min',
            'market.BTC_CQ.basis.1min.open',
        ]);
        break;
    }

    //unsubscribe
    case 2:{
        $huobi->unsubscribe([
            //market
            'market.BTC_CQ.depth.step0',
            'market.ETH_CQ.depth.step0',
            //kline
            'market.BTC-USD.index.1min',
            'market.BTC_CQ.basis.1min.open',
        ]);

        break;
    }

    case 3:{

        $huobi->subscribe([
            //market
            'market.BTC_CQ.kline.1min',
            'market.BTC_CQ.bbo',
            'market.BTC_CQ.trade.detail',
            'market.BTC_CQ.detail',
        ]);

        break;
    }

    case 4:{
        $huobi->unsubscribe([
            //market
            'market.BTC_CQ.kline.1min',
            'market.BTC_CQ.bbo',
            'market.BTC_CQ.trade.detail',
            'market.BTC_CQ.detail',
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
            'market.BTC_CQ.depth.step0',
            'market.ETH_CQ.depth.step0',

            //kline
            'market.BTC-USD.index.1min',
            'market.BTC_CQ.basis.1min.open',

            //private
            'orders.eos',
            'accounts.eos',
            'positions.eos',
            'trigger_order.eos',

            'public.btc.liquidation_orders',
            'public.btc.contract_info',
        ]);

        break;
    }

    //unsubscribe
    case 11:{
        $huobi->keysecret($key_secret[0]);

        $huobi->unsubscribe([
            //market
            'market.BTC_CQ.depth.step0',
            'market.ETH_CQ.depth.step0',

            //kline
            'market.BTC-USD.index.1min',
            'market.BTC_CQ.basis.1min.open',

            //private
            'orders.eos',
            'accounts.eos',
            'positions.eos',
            'trigger_order.eos',

            'public.btc.liquidation_orders',
            'public.btc.contract_info',
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
            'market.BTC_CQ.depth.step0',
            'market.ETH_CQ.depth.step0',
        ]);
        print_r($data);

        //The second way callback
        $huobi->getSubscribe([
            'market.BTC_CQ.depth.step0',
            'market.ETH_CQ.depth.step0',
        ],function($data){
            print_r(json_encode($data));
        });

        //The third way is to guard the process
        $huobi->getSubscribe([
            'market.BTC_CQ.depth.step0',
            'market.ETH_CQ.depth.step0',
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
            'market.BTC_CQ.depth.step0',
            //'market.ETH_CQ.depth.step0',

            'orders.eos',
            'accounts.eos',
            'positions.eos',
            //'trigger_order.eos',
        ]);
        print_r(json_encode($data));
        //die;
        //The second way callback
        $huobi->keysecret($key_secret[0]);
        $huobi->getSubscribe([
            'market.BTC_CQ.depth.step0',
            //'market.ETH_CQ.depth.step0',

            'orders.eos',
            'accounts.eos',
            'positions.eos',
            //'trigger_order.eos',
        ],function($data){
            print_r(json_encode($data));
        });

        //The third way is to guard the process
        $huobi->keysecret($key_secret[0]);
        $huobi->getSubscribe([
            'market.BTC_CQ.depth.step0',
            //'market.ETH_CQ.depth.step0',

            'orders.eos',
            'accounts.eos',
            'positions.eos',
            //'trigger_order.eos',
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
}


