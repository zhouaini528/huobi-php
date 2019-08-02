<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi;

use Lin\Huobi\Api\Spot\Subuser;
use Lin\Huobi\Api\Spot\Order;
use Lin\Huobi\Api\Spot\Market;
use Lin\Huobi\Api\Spot\Margin;
use Lin\Huobi\Api\Spot\Etf;
use Lin\Huobi\Api\Spot\Dw;
use Lin\Huobi\Api\Spot\Common;
use Lin\Huobi\Api\Spot\Account;
use Lin\Huobi\Api\Spot\Futures;
use Lin\Huobi\Api\Spot\Fee;

class HuobiSpot
{
    protected $key;
    protected $secret;
    protected $host;
    
    protected $proxy=false;
    protected $timeout=60;
    
    function __construct(string $key='',string $secret='',string $host='https://api.huobi.pro'){
        $this->key=$key;
        $this->secret=$secret;
        $this->host=$host;
    }
    
    /**
     *
     * */
    private function init(){
        return [
            'key'=>$this->key,
            'secret'=>$this->secret,
            'host'=>$this->host,
            'timeout'=>$this->timeout,
        ];
    }
    
    /**
     * Local development sets the proxy
     * @param bool|array
     * $proxy=false Default
     * $proxy=true  Local proxy http://127.0.0.1:12333
     *
     * Manual proxy
     * $proxy=[
     'http'  => 'http://127.0.0.1:12333',
     'https' => 'http://127.0.0.1:12333',
     'no'    =>  ['.cn']
     * ]
     * */
    function setProxy($proxy=true){
        $this->proxy=$proxy;
    }
    
    /**
     * Set the request timeout to 60 seconds by default
     * */
    function setTimeOut($timeout=60){
        $this->timeout=$timeout;
    }
    
    /**
     * 
     * */
    public function account(){
        $account= new Account($this->init());
        $account->proxy($this->proxy);
        return $account;
    }
    
    /**
     *
     * */
    public function common(){
        $common= new Common($this->init());
        $common->proxy($this->proxy);
        return $common;
    }
    
    /**
     *
     * */
    public function dw(){
        $dw= new Dw($this->init());
        $dw->proxy($this->proxy);
        return $dw;
    }
    
    /**
     *
     * */
    public function etf(){
        $etf= new Etf($this->init());
        $etf->proxy($this->proxy);
        return $etf;
    }
    
    /**
     *
     * */
    public function margin(){
        $margin= new Margin($this->init());
        $margin->proxy($this->proxy);
        return $margin;
    }
    
    /**
     *
     * */
    public function market(){
        $market= new Market($this->init());
        $market->proxy($this->proxy);
        return $market;
    }
    
    /**
     *
     * */
    public function order(){
        $order= new Order($this->init());
        $order->proxy($this->proxy);
        return $order;
    }
    
    /**
     *
     * */
    public function subuser(){
        $subuser= new Subuser($this->init());
        $subuser->proxy($this->proxy);
        return $subuser;
    }
    
    /**
     *
     * */
    public function futures(){
        $futures = new Futures($this->init());
        $futures->proxy($this->proxy);
        return $futures;
    }
    
    /**
     *
     * */
    public function fee(){
        $fee = new Fee($this->init());
        $fee->proxy($this->proxy);
        return $fee;
    }
}