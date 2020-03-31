<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi;



use Lin\Huobi\Api\Swap\Contract;
use Lin\Huobi\Api\Swap\Market;
use Lin\Huobi\Api\Swap\Lightning;

class HuobiSwap
{
    protected $key;
    protected $secret;
    protected $host;
    
    protected $options=[];
    
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
    public function contract(){
        return new Contract($this->init());
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
    public function lightning(){
        return  new Lightning($this->init());
    }
}