<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Spot;



use Lin\Huobi\Request;

class Wallet extends Request
{
    /**
     * GET /v2/account/deposit/address
     * */
    public function getDepositAddress(array $data=[]){
        $this->type='GET';
        $this->path='/v2/account/deposit/address';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /v2/account/withdraw/quota
     * */
    public function getWithdrawQuota(array $data=[]){
        $this->type='GET';
        $this->path='/v2/account/withdraw/quota';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /v2/account/withdraw/address
     * */
    public function getWithdrawAddress(array $data=[]){
        $this->type='GET';
        $this->path='/v2/account/withdraw/address';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *POST /v1/dw/withdraw/api/create
     * */
    public function postWithdrawApiCreate(array $data=[]){
        $this->type='POST';
        $this->path='/v1/dw/withdraw/api/create';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *POST /v1/dw/withdraw-virtual/{withdraw-id}/cancel
     * */
    public function postWithdrawCancel(array $data=[]){
        $this->type='POST';
        $this->path='/v1/dw/withdraw-virtual/'.$data['withdraw_id'].'/cancel';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /v1/query/deposit-withdraw
     * */
    public function getDepositWithdraw(array $data=[]){
        $this->type='GET';
        $this->path='/v1/query/deposit-withdraw';
        $this->data=$data;
        return $this->exec();
    }
}