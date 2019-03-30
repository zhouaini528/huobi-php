<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Spot;



use Lin\Huobi\Request;

class Account extends Request
{
    /**
     * 查询当前用户的所有账户(即account-id)
     * */
    public function get(){
        $this->type='GET';
        $this->path='/v1/account/accounts';
        return $this->exec();
    }
    
    /**
     * 查询Pro站指定账户的余额
     * /v1/account/accounts/{account-id}/balance
     * */
    public function getBalance(array $data){
        $this->type='GET';
        $this->path='/v1/account/accounts/'.$data['account-id'].'/balance';
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