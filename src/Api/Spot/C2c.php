<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Spot;



use Lin\Huobi\Request;

class C2c extends Request
{
    /**
     * POST /v2/c2c/offer
     * */
    public function postOffer(array $data=[]){
        $this->type='POST';
        $this->path=' /v2/c2c/offer';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *POST /v2/c2c/cancellation
     * */
    public function postCancellation(array $data=[]){
        $this->type='POST';
        $this->path='/v2/c2c/cancellation';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *POST /v2/c2c/cancel-all
     * */
    public function postCancelAll(array $data=[]){
        $this->type='POST';
        $this->path='/v2/c2c/cancel-all';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /v2/c2c/offers
     * */
    public function getOffers(array $data=[]){
        $this->type='GET';
        $this->path='/v2/c2c/offers';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /v2/c2c/offer
     * */
    public function getoffer(array $data=[]){
        $this->type='GET';
        $this->path='/v2/c2c/offer';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /v2/c2c/transactions
     * */
    public function getTransactions(array $data=[]){
        $this->type='GET';
        $this->path='/v2/c2c/transactions';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *POST /v2/c2c/repayment
     * */
    public function postRepayment(array $data=[]){
        $this->type='POST';
        $this->path='/v2/c2c/repayment';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /v2/c2c/repayment
     * */
    public function getRepayment(array $data=[]){
        $this->type='GET';
        $this->path='/v2/c2c/repayment';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *POST /v2/c2c/transfer
     * */
    public function getTransfer(array $data=[]){
        $this->type='GET';
        $this->path='/v2/c2c/transfer';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /v2/c2c/account
     * */
    public function getAccount(array $data=[]){
        $this->type='GET';
        $this->path='/v2/c2c/account';
        $this->data=$data;
        return $this->exec();
    }
}