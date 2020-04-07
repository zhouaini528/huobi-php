### 建议您先阅读官方文档

Huobi 文档地址 [https://huobiapi.github.io/docs/spot/v1/cn/#api](https://huobiapi.github.io/docs/spot/v1/cn/#api)

所有接口方法的初始化都与huobi提供的方法相同。更多细节 [src/api](https://github.com/zhouaini528/huobi-php/tree/master/src/Api)

大部分的接口已经完成，使用者可以根据我的设计方案继续扩展，欢迎与我一起迭代它。

[English Document](https://github.com/zhouaini528/huobi-php/blob/master/README.md)

### 其他交易所API

[Exchanges](https://github.com/zhouaini528/exchanges-php) 它包含以下所有交易所，强烈推荐使用该SDK。

[Bitmex](https://github.com/zhouaini528/bitmex-php)

[Okex](https://github.com/zhouaini528/okex-php)

[Huobi](https://github.com/zhouaini528/huobi-php)

[Binance](https://github.com/zhouaini528/binance-php)

[Kucoin](https://github.com/zhouaini528/kucoin-php)

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
    print_r(json_decode($e->getMessage(),true));
}

//List trading pairs and get the trading limit, price, and more information of different trading pairs.
try {
    $result=$huobi->market()->getTickers();
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
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
    print_r(json_decode($e->getMessage(),true));
}
sleep(1);

//Get order details by order ID.
try {
    $result=$huobi->order()->get([
        'order-id'=>$result['data'],
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}
sleep(1);

//Cancelling an unfilled order.
try {
    $result=$huobi->order()->postSubmitCancel([
        'order-id'=>$result['data']['id'],
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
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
    print_r(json_decode($e->getMessage(),true));
}
sleep(1);

//Get order details by order ID.
try {
    $result=$huobi->order()->getClientOrder([
        'clientOrderId'=>$client_order_id,
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}
sleep(1);

//Cancelling an unfilled order.
try {
    $result=$huobi->order()->postSubmitCancelClientOrder([
        'client-order-id'=>$client_order_id,
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
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
    print_r(json_decode($e->getMessage(),true));
}

//Get the balance of an account
try {
    $result=$huobi->account()->getBalance([
        'account-id'=>$result['data'][0]['id']
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
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
    print_r(json_decode($e->getMessage(),true));
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
    print_r(json_decode($e->getMessage(),true));
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
    print_r(json_decode($e->getMessage(),true));
}



//User`s position Information
try {
    $result=$huobi->contract()->postPositionInfo();
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}

//User`s Account Information
try {
    $result=$huobi->contract()->postAccountInfo();
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}

//Get Contracts Information
try {
    $result=$huobi->contract()->getContractInfo();
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
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
```

[更多用例](https://github.com/zhouaini528/huobi-php/tree/master/tests/future)

[更多API](https://github.com/zhouaini528/huobi-php/tree/master/src/Api/Futures)


### 期货永续合约 API 

```php
$huobi=new HuobiSwap($key,$secret);

//Place an Order
try {
    $result=$huobi->account()->postOrder([
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
    print_r(json_decode($e->getMessage(),true));
}

//Get Information of an Order
try {
    $result=$huobi->account()->postOrderInfo([
        'order_id'=>$result['data']['order_id'],//You can also 'xxxx,xxxx,xxxx' multiple ID
        //'client_order_id'=>'xxxx',
        'contract_code'=>'ETH-USD'
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}

//Cancel an Order
try {
    $result=$huobi->account()->postCancel([
        'order_id'=>$result['data'][0]['order_id'],//You can also 'xxxx,xxxx,xxxx' multiple ID
        //'client_order_id'=>'xxxx',
        'contract_code'=>'ETH-USD'
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}
```

[更多用例](https://github.com/zhouaini528/huobi-php/tree/master/tests/swap)

[更多API](https://github.com/zhouaini528/huobi-php/tree/master/src/Api/Swap)

