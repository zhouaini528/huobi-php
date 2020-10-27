<?php


/**
 * @author lin <465382251@qq.com>
 *
 * Fill in your key and secret and pass can be directly run
 *
 * Most of them are unfinished and need your help
 * https://github.com/zhouaini528/okex-php.git
 * */
use Lin\Huobi\HuobiSwap;

require __DIR__ .'../../../vendor/autoload.php';

include 'key_secret.php';

$huobi=new HuobiSwap($key,$secret);

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
    $result=$huobi->trade()->postOrder([
        'contract_code'=>'ETH-USD',//	string	false	BTC180914
        'price'=>'100',//	decimal	true	Price
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
sleep(1);

//Get Information of an Order
try {
    $result=$huobi->trade()->postOrderInfo([
        'order_id'=>$result['data']['order_id'],//You can also 'xxxx,xxxx,xxxx' multiple ID
        //'client_order_id'=>'xxxx',
        'contract_code'=>'ETH-USD'
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}
sleep(1);

//Cancel an Order
try {
    $result=$huobi->trade()->postCancel([
        'order_id'=>$result['data'][0]['order_id'],//You can also 'xxxx,xxxx,xxxx' multiple ID
        //'client_order_id'=>'xxxx',
        'contract_code'=>'ETH-USD'
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}
sleep(1);
