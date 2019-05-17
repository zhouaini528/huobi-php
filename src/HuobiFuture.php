<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi;



use Lin\Huobi\Api\Futures\Contract;
use Lin\Huobi\Api\Futures\Market;

class HuobiFuture
{
    protected $key;
    protected $secret;
    protected $host;
    
    protected $proxy=false;
    
    function __construct(string $key='',string $secret='',string $host='https://api.hbdm.com'){
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
     * 
     * */
    public function contract(){
        $contract= new Contract($this->init());
        $contract->proxy($this->proxy);
        return $contract;
    }
    
    /**
     *
     * */
    public function market(){
        $market= new Market($this->init());
        $market->proxy($this->proxy);
        return $market;
    }
    
}