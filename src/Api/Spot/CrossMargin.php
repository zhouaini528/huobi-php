<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Spot;



use Lin\Huobi\Request;

class CrossMargin extends Request
{
    /**
     *POST /v1/cross-margin/transfer-in
     * */
    public function postTransferIn(array $data=[]){
        $this->type='POST';
        $this->path='/v1/cross-margin/transfer-in';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *POST /v1/cross-margin/transfer-out
     * */
    public function postTransferOut(array $data=[]){
        $this->type='POST';
        $this->path='/v1/cross-margin/transfer-out';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /v1/cross-margin/loan-info
     * */
    public function get(array $data=[]){
        $this->type='GET';
        $this->path='/v1/cross-margin/loan-info';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *POST /v1/cross-margin/orders
     * */
    public function postOrders(array $data=[]){
        $this->type='POST';
        $this->path='/v1/cross-margin/orders';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *POST /v1/cross-margin/orders/{order-id}/repay
     * */
    public function postOrdersRepay(array $data=[]){
        $this->type='POST';
        $this->path='/v1/cross-margin/orders/'.$data['order_id'].'/repay';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /v1/cross-margin/loan-orders
     * */
    public function getLoanOrders(array $data=[]){
        $this->type='GET';
        $this->path='/v1/cross-margin/loan-orders';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /v1/cross-margin/accounts/balance
     * */
    public function getAccountsBalance(array $data=[]){
        $this->type='GET';
        $this->path='/v1/cross-margin/accounts/balance';
        $this->data=$data;
        return $this->exec();
    }
}