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
    'log'=>['filename'=>'swap'],

    //Daemons address and port,default 0.0.0.0:2211
    //'global'=>'127.0.0.1:2211',

    //Channel data update time,default 0.5 seconds
    //'data_time'=>0.5,

    //Set up subscription platform, default 'spot'
    'platform'=>'swap', //options value 'spot' 'future' 'swap' 'linear' 'option'
    //Or you can set it like this
    /*
    'platform'=>[
        'type'=>'swap',
        'market'=>'ws://api.hbdm.com/swap-ws',//Market Data Request and Subscription
        'order'=>'ws://api.hbdm.com/swap-notification',//Order Push Subscription
        'kline'=>'ws://api.hbdm.com/ws_index',//Index Kline Data and Basis Data Subscription

        //'market'=>'ws://api.btcgateway.pro/swap-ws',
        //'order'=>'ws://api.btcgateway.pro/swap-notification',
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
            'market.BTC-USD.depth.step0',
            'market.ETH-USD.depth.step0',

            //kline index and basis
            'market.BTC-USD.premium_index.1min',
            'market.btc-USD.estimated_rate.1min',
            'market.BTC-USD.basis.1min.open',
        ]);
        break;
    }

    //unsubscribe
    case 2:{
        $huobi->unsubscribe([
            //market
            'market.BTC-USD.depth.step0',
            'market.ETH-USD.depth.step0',

            //kline index and basis
            'market.BTC-USD.premium_index.1min',
            'market.btc-USD.estimated_rate.1min',
            'market.BTC-USD.basis.1min.open',
        ]);

        break;
    }

    case 3:{

        $huobi->subscribe([
            //market
            'market.BTC-USD.kline.1min',
            'market.BTC-USD.bbo',
            'market.BTC-USD.trade.detail',
            'market.BTC-USD.detail',
        ]);

        break;
    }

    case 4:{
        $huobi->unsubscribe([
            //market
            'market.BTC-USD.kline.1min',
            'market.BTC-USD.bbo',
            'market.BTC-USD.trade.detail',
            'market.BTC-USD.detail',
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
            'market.BTC-USD.depth.step0',
            'market.ETH-USD.depth.step0',

            //kline index and basis
            'market.BTC-USD.premium_index.1min',
            'market.btc-USD.estimated_rate.1min',
            'market.BTC-USD.basis.1min.open',

            //private
            'orders.eos-usd',
            'accounts.eos-usd',
            'positions.eos-usd',
            'trigger_order.eos-usd',

            'public.btc-usd.liquidation_orders',
            'public.btc-usd.contract_info',
            'public.btc-usd.funding_rate',
        ]);

        break;
    }

    //unsubscribe
    case 11:{
        $huobi->keysecret($key_secret[0]);

        $huobi->unsubscribe([
            //market
            'market.BTC-USD.depth.step0',
            'market.ETH-USD.depth.step0',

            //kline index and basis
            'market.BTC-USD.premium_index.1min',
            'market.btc-USD.estimated_rate.1min',
            'market.BTC-USD.basis.1min.open',

            //private
            'orders.eos-usd',
            'accounts.eos-usd',
            'positions.eos-usd',
            'trigger_order.eos-usd',

            'public.btc-usd.liquidation_orders',
            'public.btc-usd.contract_info',
            'public.btc-usd.funding_rate',
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
            'market.BTC-USD.depth.step0',
            'market.ETH-USD.depth.step0',
        ]);
        print_r($data);

        //The second way callback
        $huobi->getSubscribe([
            'market.BTC-USD.depth.step0',
            'market.ETH-USD.depth.step0',
        ],function($data){
            print_r(json_encode($data));
        });

        //The third way is to guard the process
        $huobi->getSubscribe([
            'market.BTC-USD.depth.step0',
            'market.ETH-USD.depth.step0',
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
            'market.BTC-USD.depth.step0',
            //'market.ETH-USD.depth.step0',

            'orders.eos',
            'accounts.eos',
            'positions.eos',
            //'trigger_order.eos',
        ]);
        print_r(json_encode($data));

        //The second way callback
        $huobi->keysecret($key_secret[0]);
        $huobi->getSubscribe([
            'market.BTC-USD.depth.step0',
            //'market.ETH-USD.depth.step0',

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
            'market.BTC-USD.depth.step0',
            //'market.ETH-USD.depth.step0',

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


