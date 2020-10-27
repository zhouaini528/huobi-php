<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi;

use Lin\Huobi\Api\Linear\Market;
use Lin\Huobi\Api\Linear\Account;
use Lin\Huobi\Api\Linear\Trade;

class HuobiLinear
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
    public function account(){
        return new Account($this->init());
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
    public function trade(){
        return new Trade($this->init());
    }
}
