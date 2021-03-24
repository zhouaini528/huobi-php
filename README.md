### It is recommended that you read the official document first

Huobi docs [https://huobiapi.github.io/docs/spot/v1/cn/#api](https://huobiapi.github.io/docs/spot/v1/cn/#api)

All interface methods are initialized the same as those provided by huobi. See details [src/api](https://github.com/zhouaini528/huobi-php/tree/master/src/Api)

Support [Websocket](https://github.com/zhouaini528/huobi-php/blob/master/README.md#Websocket)

Most of the interface is now complete, and the user can continue to extend it based on my design, working with me to improve it.

[中文文档](https://github.com/zhouaini528/huobi-php/blob/master/README_CN.md)

### Other exchanges API

[Exchanges](https://github.com/zhouaini528/exchanges-php) It includes all of the following exchanges and is highly recommended.

[Bitmex](https://github.com/zhouaini528/bitmex-php) Support [Websocket](https://github.com/zhouaini528/bitmex-php/blob/master/README.md#Websocket)

[Okex](https://github.com/zhouaini528/okex-php) Support [Websocket](https://github.com/zhouaini528/okex-php/blob/master/README.md#Websocket)

[Huobi](https://github.com/zhouaini528/huobi-php) Support [Websocket](https://github.com/zhouaini528/huobi-php/blob/master/README.md#Websocket)

[Binance](https://github.com/zhouaini528/binance-php) Support [Websocket](https://github.com/zhouaini528/binance-php/blob/master/README.md#Websocket)

[Kucoin](https://github.com/zhouaini528/kucoin-php)

[Mxc](https://github.com/zhouaini528/Mxc-php)

[Coinbase](https://github.com/zhouaini528/coinbase-php)

[ZB](https://github.com/zhouaini528/zb-php)

[Bitfinex](https://github.com/zhouaini528/bitfinex-php)

[Bittrex](https://github.com/zhouaini528/bittrex-php)

[Kraken](https://github.com/zhouaini528/kraken-php)

[Gate](https://github.com/zhouaini528/gate-php)   

[Bigone](https://github.com/zhouaini528/bigone-php)   

[Crex24](https://github.com/zhouaini528/crex24-php)   

[Bybit](https://github.com/zhouaini528/bybit-php)  

[Coinbene](https://github.com/zhouaini528/coinbene-php)   

[Bitget](https://github.com/zhouaini528/bitget-php)   

[Poloniex](https://github.com/zhouaini528/poloniex-php)

#### Installation
```
composer require linwj/huobi
```

Support for more request Settings [More](https://github.com/zhouaini528/huobi-php/blob/master/tests/spot/proxy.php#L21)
```php
$huobi=new HuobiSpot();

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
```

### Spot Trading API

Market related API [More](https://github.com/zhouaini528/huobi-php/blob/master/tests/spot/market.php)

```php
$huobi=new HuobiSpot();

//Get market data. This endpoint provides the snapshots of market data and can be used without verifications.
try {
    $result=$huobi->market()->getDepth([
        'symbol'=>'btcusdt',
        //'type'=>'step3'   default step0
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}

//List trading pairs and get the trading limit, price, and more information of different trading pairs.
try {
    $result=$huobi->market()->getTickers();
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}
```

Order related API [More](https://github.com/zhouaini528/huobi-php/blob/master/tests/spot/order.php)

```php
$huobi=new HuobiSpot($key,$secret);

//Place an Order
try {
    $result=$huobi->order()->postPlace([
        'account-id'=>$account_id,
        'symbol'=>'btcusdt',
        'type'=>'buy-limit',
        'amount'=>'0.001',
        'price'=>'100',
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}
sleep(1);

//Get order details by order ID.
try {
    $result=$huobi->order()->get([
        'order-id'=>$result['data'],
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}
sleep(1);

//Cancelling an unfilled order.
try {
    $result=$huobi->order()->postSubmitCancel([
        'order-id'=>$result['data']['id'],
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}

//***********************Customize the order ID
//Place an Order
try {
    $client_order_id=rand(10000,99999).rand(10000,99999);
    $result=$huobi->order()->postPlace([
        'account-id'=>$account_id,
        'symbol'=>'btcusdt',
        'type'=>'buy-limit',
        'amount'=>'0.001',
        'price'=>'1000',
        'client-order-id'=>$client_order_id,
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}
sleep(1);

//Get order details by order ID.
try {
    $result=$huobi->order()->getClientOrder([
        'clientOrderId'=>$client_order_id,
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}
sleep(1);

//Cancelling an unfilled order.
try {
    $result=$huobi->order()->postSubmitCancelClientOrder([
        'client-order-id'=>$client_order_id,
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}
```

Accounts related API [More](https://github.com/zhouaini528/huobi-php/blob/master/tests/spot/account.php)

```php
$huobi=new HuobiSpot($key,$secret);

//get the status of an account
try {
    $result=$huobi->account()->get();
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}

//Get the balance of an account
try {
    $result=$huobi->account()->getBalance([
        'account-id'=>$result['data'][0]['id']
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}

```

[More use cases](https://github.com/zhouaini528/huobi-php/tree/master/tests/spot)

[More API](https://github.com/zhouaini528/huobi-php/tree/master/src/Api/Spot)

### Futures Trading API

Contract related API [More](https://github.com/zhouaini528/huobi-php/blob/master/tests/future/contract.php)

```php
$huobi=new HuobiFuture($key,$secret);

//Place an Order
try {
    $result=$huobi->contract()->postOrder([
        'symbol'=>'BTC',//string    false   "BTC","ETH"...
        'contract_type'=>'quarter',//   string  false   Contract Type ("this_week": "next_week": "quarter":)
        'contract_code'=>'BTC190628',// string  false   BTC180914
        'price'=>'100',//   decimal true    Price
        'volume'=>'1',//    long    true    Numbers of orders (amount)
        'direction'=>'buy',//   string  true    Transaction direction
        'offset'=>'open',// string  true    "open", "close"
        //'client_order_id'=>'',//long  false   Clients fill and maintain themselves, and this time must be greater than last time
        //lever_rate    int true    Leverage rate [if“Open”is multiple orders in 10 rate, there will be not multiple orders in 20 rate
        //order_price_type   string true    "limit", "opponent"
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}

//Get Information of an Order
try {
    $result=$huobi->contract()->postOrderInfo([
        'order_id'=>'xxxx',//You can also 'xxxx,xxxx,xxxx' multiple ID
        //'client_order_id'=>'xxxx',
        'symbol'=>'BTC'
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}

//Cancel an Order
try {
    $result=$huobi->contract()->postCancel([
        'order_id'=>'xxxx',//You can also 'xxxx,xxxx,xxxx' multiple ID
        //'client_order_id'=>'xxxx',
        'symbol'=>'BTC'
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}



//User`s position Information
try {
    $result=$huobi->contract()->postPositionInfo();
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}

//User`s Account Information
try {
    $result=$huobi->contract()->postAccountInfo();
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}

//Get Contracts Information
try {
    $result=$huobi->contract()->getContractInfo();
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}
```

Market related API [More](https://github.com/zhouaini528/huobi-php/blob/master/tests/future/market.php)

```php
$huobi=new HuobiFuture();

//The Last Trade of a Contract
try {
    $result=$huobi->market()->getTrade([
        'symbol'=>'BTC_CQ'
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}

//Request a Batch of Trade Records of a Contract
try {
    $result=$huobi->market()->getHistoryTrade([
        'symbol'=>'BTC_CQ',
        //'size'=>100
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}

//Get Market Depth
try {
    $result=$huobi->market()->getDepth([
        'symbol'=>'BTC_CQ',
        'type'=>'step1'
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}
```

[More use cases](https://github.com/zhouaini528/huobi-php/tree/master/tests/future)

[More API](https://github.com/zhouaini528/huobi-php/tree/master/src/Api/Futures)

### Coin Margined Swap API 

```php
$huobi=new HuobiSwap($key,$secret);
//or new
//$huobi=new HuobiLinear($key,$secret);

//Place an Order
try {
    $result=$huobi->trade()->postOrder([
        'contract_code'=>'ETH-USD',//   string  false   BTC180914
        'price'=>'100',//   decimal true    Price
        'volume'=>'1',//    long    true    Numbers of orders (amount)
        'direction'=>'buy',//   string  true    Transaction direction
        'offset'=>'open',// string  true    "open", "close"
        'order_price_type'=>'limit',//"limit", "opponent"
        'lever_rate'=>20,//int  true    Leverage rate [if“Open”is multiple orders in 10 rate, there will be not multiple orders in 20 rate
        
        //'client_order_id'=>'',//long  false   Clients fill and maintain themselves, and this time must be greater than last time
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}

//Get Information of an Order
try {
    $result=$huobi->trade()->postOrderInfo([
        'order_id'=>$result['data']['order_id'],//You can also 'xxxx,xxxx,xxxx' multiple ID
        //'client_order_id'=>'xxxx',
        'contract_code'=>'ETH-USD'
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}

//Cancel an Order
try {
    $result=$huobi->trade()->postCancel([
        'order_id'=>$result['data'][0]['order_id'],//You can also 'xxxx,xxxx,xxxx' multiple ID
        //'client_order_id'=>'xxxx',
        'contract_code'=>'ETH-USD'
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}
```

[More Test](https://github.com/zhouaini528/huobi-php/tree/master/tests/swap)

[More Api](https://github.com/zhouaini528/huobi-php/tree/master/src/Api/Swap)

### Websocket

Websocket has two services, server and client. The server is responsible for dealing with the new connection of the exchange, data receiving, authentication and login. Client is responsible for obtaining and processing data.Support 'Spot' and 'Futures' and 'Coin Margined' and 'Swap USDT Margined' and 'Swap Option'
#### Spot Websocket Demo

Server initialization must be started in Linux CLI mode.
```php
use \Lin\Huobi\HuobiWebSocket;
require __DIR__ .'./vendor/autoload.php';

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

    //Channel data update time,default 0.5 seconds
    //'data_time'=>0.5,

    //Number of messages WS queue shuold hold, default 100
    //'queue_count'=>100,

    //Set up subscription platform, default 'spot'
    'platform'=>'spot', //options value 'spot' 'future' 'swap' 'linear' 'option'
    //Or you can set it like this
    'platform'=>[
        'type'=>'spot',//options value 'spot' 'future' 'swap' 'linear' 'option'
        'market'=>'ws://api.huobi.pro/ws',//Market Data Request and Subscription
        'order'=>'ws://api.huobi.pro/ws/v2',//Order Push Subscription

        //'market'=>'ws://api-aws.huobi.pro/ws',
        //'order'=>'ws://api-aws.huobi.pro/ws/v2',
    ],
]);

$huobi->start();
```

If you want to test, you can "php server.php start" immediately outputs the log at the terminal.

If you want to deploy, you can "php server.php start -d" enables resident process mode, and enables "log=>true" to view logs.

[More Test](https://github.com/zhouaini528/huobi-php/tree/master/tests/websocket)

Client side initialization.
```php
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

    //Channel data update time,default 0.5 seconds
    //'data_time'=>0.5,

    //Number of messages WS queue shuold hold, default 100
    //'queue_count'=>100,

    //Set up subscription platform, default 'spot'
    'platform'=>'spot', //options value 'spot' 'future' 'swap' 'linear' 'option'
    //Or you can set it like this
    'platform'=>[
        'type'=>'spot',//options value 'spot' 'future' 'swap' 'linear' 'option'
        'market'=>'ws://api.huobi.pro/ws',//Market Data Request and Subscription
        'order'=>'ws://api.huobi.pro/ws/v2',//Order Push Subscription

        //'market'=>'ws://api-aws.huobi.pro/ws',
        //'order'=>'ws://api-aws.huobi.pro/ws/v2',
    ],
]);
```

Subscribe
```php
//You can only subscribe to public channels
$huobi->subscribe([
    'market.btcusdt.depth.step0',
    'market.bchusdt.depth.step0',
]);

//You can also subscribe to both private and public channels.If keysecret() is set, all private channels will be subscribed by default
$huobi->keysecret([
    'key'=>'xxxxxxxxx',
    'secret'=>'xxxxxxxxx',
]);
$huobi->subscribe([
    //market
    'market.btcusdt.depth.step0',
    'market.bchusdt.depth.step0',

    //private
    'orders#btcusdt',
    'trade.clearing#btcusdt#1',
    'accounts.update#1',
]);
```

Unsubscribe
```php
//Unsubscribe from public channels
$huobi->unsubscribe([
    'market.btcusdt.depth.step0',
    'market.bchusdt.depth.step0',
]);

//Unsubscribe from public and private channels.If keysecret() is set, all private channels will be Unsubscribed by default
$huobi->keysecret([
    'key'=>'xxxxxxxxx',
    'secret'=>'xxxxxxxxx',
]);
$huobi->unsubscribe([
    //market
    'market.btcusdt.depth.step0',
    'market.bchusdt.depth.step0',

    //private
    'orders#btcusdt',
    'trade.clearing#btcusdt#1',
    'accounts.update#1',
]);
```

Get all channel subscription data
```php
//The first way
$data=$huobi->getSubscribe();
print_r(json_encode($data));

//The second way callback
$huobi->getSubscribe(function($data){
    print_r(json_encode($data));
});

//The third way is to guard the process
$huobi->getSubscribe(function($data){
    print_r(json_encode($data));
},true);
```

Get partial channel subscription data
```php
//The first way
$data=$huobi->getSubscribe([
    'market.btcusdt.depth.step0',
    'market.bchusdt.depth.step0',
]);
print_r(json_encode($data));

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
```

Get partial private channel subscription data
```php
//The first way
$huobi->keysecret($key_secret);
$data=$huobi->getSubscribe();//Return all data of private channel
print_r(json_encode($data));

//The second way callback
$huobi->keysecret($key_secret);
$huobi->getSubscribe([//Return data private and market 
    //market
    'market.btcusdt.depth.step0',
    'market.bchusdt.depth.step0',

    //private
    'orders#btcusdt',
    'trade.clearing#btcusdt#1',
    'accounts.update#1',
],function($data){
    print_r(json_encode($data));
});

//The third way is to guard the process
$huobi->keysecret($key_secret);
$huobi->getSubscribe([//Resident process to get data return frequency $huobi->config['data_time']=0.5s
    //market
    'market.btcusdt.depth.step0',
    'market.bchusdt.depth.step0',

    //private
    'orders#btcusdt',
    'trade.clearing#btcusdt#1',
    'accounts.update#1',
],function($data){
    print_r(json_encode($data));
},true);
```

[Spot Websocket More Test](https://github.com/zhouaini528/huobi-php/tree/master/tests/websocket/client_spot.php)

[Futures Websocket More Test](https://github.com/zhouaini528/huobi-php/tree/master/tests/websocket/client_future.php)

[Coin Margined Websocket More Test](https://github.com/zhouaini528/huobi-php/tree/master/tests/websocket/client_swap.php)

[Swap USDT Margined Websocket More Test](https://github.com/zhouaini528/huobi-php/tree/master/tests/websocket/client_linear.php)

