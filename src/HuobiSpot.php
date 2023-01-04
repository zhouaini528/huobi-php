<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi;

use Lin\Huobi\Api\Spot\Reference;
use Lin\Huobi\Api\Spot\Settings;
use Lin\Huobi\Api\Spot\Subuser;
use Lin\Huobi\Api\Spot\Order;
use Lin\Huobi\Api\Spot\Market;
use Lin\Huobi\Api\Spot\Margin;
use Lin\Huobi\Api\Spot\Etf;
use Lin\Huobi\Api\Spot\Common;
use Lin\Huobi\Api\Spot\Account;
use Lin\Huobi\Api\Spot\Wallet;
use Lin\Huobi\Api\Spot\AlgoOrder;
use Lin\Huobi\Api\Spot\C2c;
use Lin\Huobi\Api\Spot\CrossMargin;

class HuobiSpot
{
    protected $key;
    protected $secret;
    protected $host;
    
    protected $options=[];
    
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
            'options'=>$this->options,
        ];
    }
    
    /**
     * 
     * */
    function setOptions(array $options=[]){
        $this->options=$options;
    }
    
    /**
     * 
     * */
    public function account(){
        return  new Account($this->init());
    }
    
    /**
     *
     * */
    public function algoorder(){
        return  new AlgoOrder($this->init());
    }
    
    /**
     *
     * */
    public function c2c(){
        return  new C2c($this->init());
    }
    
    /**
     *
     * */
    public function common(){
        return  new Common($this->init());
    }
    
    /**
     *
     * */
    public function crossmargin(){
        return  new CrossMargin($this->init());
    }
    
    /**
     *
     * */
    public function etf(){
        return  new Etf($this->init());
    }
    
    /**
     *
     * */
    public function margin(){
        return  new Margin($this->init());
    }
    
    /**
     *
     * */
    public function market(){
        return  new Market($this->init());
    }
    
    /**
     *
     * */
    public function order(){
        return  new Order($this->init());
    }

    /**
     *
     * */
    public function reference(){
        return  new Reference($this->init());
    }

    /**
     *
     * */
    public function settings(){
        return  new Settings($this->init());
    }
    
    /**
     *
     * */
    public function subuser(){
        return  new Subuser($this->init());
    }
    
    /**
    *
    * */
    public function wallet(){
        return  new Wallet($this->init());
    }
}