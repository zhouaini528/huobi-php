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


//Place an Order
try {
    $result=$huobi->contract()->postOrder([
        'symbol'=>'BTC',//string	false	"BTC","ETH"...
        'contract_type'=>'quarter',//	string	false	Contract Type ("this_week": "next_week": "quarter":)
        'contract_code'=>'BTC190628',//	string	false	BTC180914
        'price'=>'100',//	decimal	true	Price
        'volume'=>'1',//	long	true	Numbers of orders (amount)
        'direction'=>'buy',//	string	true	Transaction direction
        'offset'=>'open',//	string	true	"open", "close"
        //'client_order_id'=>'',//long	false	Clients fill and maintain themselves, and this time must be greater than last time
        //lever_rate	int	true	Leverage rate [if“Open”is multiple orders in 10 rate, there will be not multiple orders in 20 rate
        //order_price_type	 string	true	"limit", "opponent"
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