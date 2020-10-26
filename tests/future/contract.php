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

$huobi=new HuobiFuture($key,$secret);

//You can set special needs
$huobi->setOptions([
    //Set the request timeout to 60 seconds by default
    'timeout'=>10,

    //If you are developing locally and need an agent, you can set this
    //'proxy'=>true,
    //More flexible Settings
    /* 'proxy'=>[
     'http'  => 'http://127.0.0.1:12333',
     'https' => 'http://127.0.0.1:12333',
     'no'    =>  ['.cn']
     ], */
    //Close the certificate
    //'verify'=>false,
]);

//Place an Order
try {
    $result=$huobi->contract()->postOrder([
        'symbol'=>'EOS',//string	false	"BTC","ETH"...
        'contract_type'=>'quarter',//	string	false	Contract Type ("this_week": "next_week": "quarter":)
        'contract_code'=>'EOS201225',//	string	false	BTC180914
        'price'=>'1',//	decimal	true	Price
        'volume'=>'1',//	long	true	Numbers of orders (amount)
        'direction'=>'buy',//	string	true	Transaction direction
        'offset'=>'open',//	string	true	"open", "close"
        'order_price_type'=>'limit',//"limit", "opponent"
        'lever_rate'=>20,//int	true	Leverage rate [if“Open”is multiple orders in 10 rate, there will be not multiple orders in 20 rate

        //'client_order_id'=>'',//long	false	Clients fill and maintain themselves, and this time must be greater than last time
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}

//Get Information of an Order
try {
    $result=$huobi->contract()->postOrderInfo([
        'order_id'=>$result['data']['order_id'],//You can also 'xxxx,xxxx,xxxx' multiple ID
        //'client_order_id'=>'xxxx',
        'symbol'=>'EOS'
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}

//Cancel an Order
try {
    $result=$huobi->contract()->postCancel([
        'order_id'=>$result['data'][0]['order_id'],//You can also 'xxxx,xxxx,xxxx' multiple ID
        //'client_order_id'=>'xxxx',
        'symbol'=>'EOS'
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


/*try {
    $result=$huobi->contract()->postOpenOrders([
        'symbol'=>'EOS'
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}

try {
    $result=$huobi->contract()->postCancelAll([
        'symbol'=>'EOS'
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}

try {
    $result=$huobi->contract()->postBatchOrder([
        'orders_data'=>[
            [
                'symbol'=>'EOS',
                'contract_type'=>'quarter',
                'contract_code'=>'EOS201225',
                'price'=>'1',
                'volume'=>'1',
                'direction'=>'buy',
                'offset'=>'open',
                'order_price_type'=>'limit',
                'lever_rate'=>20,
            ],
            [
                'symbol'=>'EOS',
                'contract_type'=>'quarter',
                'contract_code'=>'EOS201225',
                'price'=>'1.1',
                'volume'=>'1',
                'direction'=>'buy',
                'offset'=>'open',
                'order_price_type'=>'limit',
                'lever_rate'=>20,
            ],
        ],
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}*/
