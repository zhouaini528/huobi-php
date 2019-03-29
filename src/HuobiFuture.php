<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi;



class HuobiFuture
{
    protected $key;
    protected $secret;
    protected $passphrase;
    protected $host;
    
    function __construct(string $key='',string $secret='',string $passphrase='',string $host='https://api.huobi.pro'){
        $this->key=$key;
        $this->secret=$secret;
        $this->host=$host;
        $this->passphrase=$passphrase;
    }
    
    /**
     *
     * */
    private function init(){
        return [
            'key'=>$this->key,
            'secret'=>$this->secret,
            'passphrase'=>$this->passphrase,
            'host'=>$this->host,
        ];
    }
    
    
}