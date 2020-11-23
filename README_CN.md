### 建议您先阅读官方文档

Huobi 文档地址 [https://huobiapi.github.io/docs/spot/v1/cn/#api](https://huobiapi.github.io/docs/spot/v1/cn/#api)

所有接口方法的初始化都与huobi提供的方法相同。更多细节 [src/api](https://github.com/zhouaini528/huobi-php/tree/master/src/Api)

支持[Websocket](https://github.com/zhouaini528/huobi-php/blob/master/README_CN.md#Websocket)

大部分的接口已经完成，使用者可以根据我的设计方案继续扩展，欢迎与我一起迭代它。

[English Document](https://github.com/zhouaini528/huobi-php/blob/master/README.md)

### 其他交易所API

[Exchanges](https://github.com/zhouaini528/exchanges-php) 它包含以下所有交易所，强烈推荐使用该SDK。

[Bitmex](https://github.com/zhouaini528/bitmex-php) 支持[Websocket](https://github.com/zhouaini528/bitmex-php/blob/master/README_CN.md#Websocket)

[Okex](https://github.com/zhouaini528/okex-php) 支持[Websocket](https://github.com/zhouaini528/okex-php/blob/master/README_CN.md#Websocket)

[Huobi](https://github.com/zhouaini528/huobi-php) 支持[Websocket](https://github.com/zhouaini528/huobi-php/blob/master/README_CN.md#Websocket)

[Binance](https://github.com/zhouaini528/binance-php) 支持[Websocket](https://github.com/zhouaini528/binance-php/blob/master/README_CN.md#Websocket)

[Kucoin](https://github.com/zhouaini528/Kucoin-php)

[Mxc](https://github.com/zhouaini528/mxc-php)

[Coinbase](https://github.com/zhouaini528/coinbase-php)

[ZB](https://github.com/zhouaini528/zb-php)

[Bitfinex](https://github.com/zhouaini528/zb-php)

[Bittrex](https://github.com/zhouaini528/bittrex-php)

[Gate](https://github.com/zhouaini528/gate-php)

[Bigone](https://github.com/zhouaini528/bigone-php)   

[Crex24](https://github.com/zhouaini528/crex24-php)   

#### 安装方式
```
composer require linwj/huobi
```

支持更多的请求设置 [More](https://github.com/zhouaini528/huobi-php/blob/master/tests/spot/proxy.php#L21)
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

### 现货交易 API

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

[更多用例](https://github.com/zhouaini528/huobi-php/tree/master/tests/spot)

[更多API](https://github.com/zhouaini528/huobi-php/tree/master/src/Api/Spot)

### 期货交割合约 API

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

[更多用例](https://github.com/zhouaini528/huobi-php/tree/master/tests/future)

[更多API](https://github.com/zhouaini528/huobi-php/tree/master/src/Api/Futures)


### 期货永续合约 API 

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

[更多用例](https://github.com/zhouaini528/huobi-php/tree/master/tests/swap)

[更多API](https://github.com/zhouaini528/huobi-php/tree/master/src/Api/Swap)

### Websocket

Websocket有两个服务server和client，server负责处理交易所新连接、数据接收、认证登陆等等。client负责获取数据、处理数据。支持现货(spot)、交割合约(future)、永续合约(swap)、USDT永续合约(linear)

#### 现货websocket为例

Server端初始化，必须在cli模式下开启。
```php
use \Lin\Huobi\HuobiWebSocket;
require __DIR__ .'./vendor/autoload.php';

$huobi=new HuobiWebSocket();

$huobi->config([
    //是否开启日志,默认未开启 false
    //'log'=>true,
    //可以设置日志名称，默认开启日志
    'log'=>['filename'=>'spot'],

    //进程服务端口地址,默认 0.0.0.0:2211
    //'global'=>'127.0.0.1:2211',

    //频道数据更新时间,默认 0.5 秒
    //'data_time'=>0.5,

    //设置订阅平台, 默认 'spot'
    'platform'=>'spot', //参数值为 'spot' 'future' 'swap' 'linear' 'option'
    //或者也可以这样更灵活的设置
    'platform'=>[
        'type'=>'spot',//参数值为 'spot' 'future' 'swap' 'linear' 'option'
        'market'=>'ws://api.huobi.pro/ws',//行情地址
        'order'=>'ws://api.huobi.pro/ws/v2',//订单地址

        //'market'=>'ws://api-aws.huobi.pro/ws',
        //'order'=>'ws://api-aws.huobi.pro/ws/v2',
    ],
]);

$huobi->start();
```

如果你要测试，你可以 php server.php start 可以在终端即时输出日志。

如果你要部署，你可以 php server.php start -d  开启常驻进程模式，并开启'log'=>true 查看日志。

[更多用例请查看](https://github.com/zhouaini528/huobi-php/tree/master/tests/websocket)


Client端初始化。
```php
$huobi=new HuobiWebSocket();

$huobi->config([
    //是否开启日志,默认未开启 false
    //'log'=>true,
    //可以设置日志名称，默认开启日志
    'log'=>['filename'=>'spot'],

    //进程服务端口地址,默认 0.0.0.0:2211
    //'global'=>'127.0.0.1:2211',

    //频道数据更新时间,默认 0.5 秒
    //'data_time'=>0.5,

    //设置订阅平台, 默认 'spot'
    'platform'=>'spot', //参数值为 'spot' 'future' 'swap' 'linear' 'option'
    //或者也可以这样更灵活的设置
    'platform'=>[
        'type'=>'spot',//参数值为 'spot' 'future' 'swap' 'linear' 'option'
        'market'=>'ws://api.huobi.pro/ws',//行情地址
        'order'=>'ws://api.huobi.pro/ws/v2',//订单地址

        //'market'=>'ws://api-aws.huobi.pro/ws',
        //'order'=>'ws://api-aws.huobi.pro/ws/v2',
    ],
]);
```

频道订阅
```php
//你可以只订阅公共频道
$huobi->subscribe([
    'market.btcusdt.depth.step0',
    'market.bchusdt.depth.step0',
]);

//你也可以私人频道与公共频道混合订阅，设置了keysecret默认会订阅私人所有频道
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

频道订阅取消
```php
//取消订阅公共频道
$huobi->unsubscribe([
    'market.btcusdt.depth.step0',
    'market.bchusdt.depth.step0',
]);

//取消私人频道与公共频道混合订阅，设置了keysecret默认会取消订阅私人所有频道
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

获取全部频道订阅数据
```php
//第一种方式，直接获取当前最新数据
$data=$huobi->getSubscribes();
print_r(json_encode($data));


//第二种方式，通过回调函数，获取当前最新数据
$huobi->getSubscribes(function($data){
    print_r(json_encode($data));
});

//第二种方式，通过回调函数并开启常驻进程，获取当前最新数据
$huobi->getSubscribes(function($data){
    print_r(json_encode($data));
},true);
```

获取部分频道订阅数据
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

获取私有频道订阅数据
```php
//The first way
$huobi->keysecret($key_secret);
$data=$huobi->getSubscribe();//返回私有频道所有数据
print_r(json_encode($data));

//The second way callback
$huobi->keysecret($key_secret);
$huobi->getSubscribe([//以回调方法返回数据
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
$huobi->getSubscribe([//以开启常驻进程方法获取数据,数据返回频率 $huobi->config['data_time']=0.5s
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

[现货websocket(spot)更多用例](https://github.com/zhouaini528/huobi-php/tree/master/tests/websocket/client_spot.php)

[交割合约websocket(future)更多用例](https://github.com/zhouaini528/huobi-php/tree/master/tests/websocket/client_future.php)

[永续合约websocket(swap)更多用例](https://github.com/zhouaini528/huobi-php/tree/master/tests/websocket/client_swap.php)

[USDT永续合约websocket(linear)更多用例](https://github.com/zhouaini528/huobi-php/tree/master/tests/websocket/client_linear.php)


