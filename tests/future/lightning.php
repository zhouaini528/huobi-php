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

//The Last Trade of a Contract
try {
    $result=$huobi->lightning()->postClosePosition([
        'symbol'=>'ETC',//string	false	"BTC","ETH"...
        'contract_type'=>'quarter',//	string	false	Contract Type ("this_week": "next_week": "quarter":)
        'contract_code'=>'ETC191227',//	string	false	BTC180914
        'volume'=>1,
        'direction'=>'sell',
        //'client_order_id'=>rand(100000,999999)
        /*
        symbol	false	string	品种代码	"BTC","ETH"...
        contract_type	false	string	合约类型	“this_week”:当周，“next_week”:次周，“quarter”:季度
        contract_code	false	string	合约代码	BTC190903
        volume	true	int	委托数量（张）
        direction	true	string	“buy”:买，“sell”:卖
        client_order_id	false	int	（API）客户自己填写和维护，必须保持唯一	
        */
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}