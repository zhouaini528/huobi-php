<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Spot;



use Lin\Huobi\Request;

class Account extends Request
{
    /**
     *
     * */
    public function get(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *
     * */
    public function getBalance(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *母子账号	GET /v1/account/accounts/{sub-uid}
     * */
    public function getSubuser(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
}