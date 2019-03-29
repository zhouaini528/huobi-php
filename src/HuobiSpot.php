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

class HuobiSpot
{
    protected $key;
    protected $secret;
    protected $host;
    
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
        ];
    }
    
    /**
     * 
     * */
    public function account(){
        return new Account($this->init());
    }
    
    /**
     *
     * */
    public function common(){
        return new Common($this->init());
    }
    
    /**
     *
     * */
    public function dw(){
        return new Dw($this->init());
    }
    
    /**
     *
     * */
    public function etf(){
        return new Etf($this->init());
    }
    
    /**
     *
     * */
    public function margin(){
        return new Margin($this->init());
    }
    
    /**
     *
     * */
    public function market(){
        return new Market($this->init());
    }
    
    /**
     *
     * */
    public function order(){
        return new Order($this->init());
    }
    
    /**
     *
     * */
    public function subuser(){
        return new Subuser($this->init());
    }
}