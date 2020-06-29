<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Spot;



use Lin\Huobi\Request;

class Subuser extends Request
{
    /**
     *POST /v2/sub-user/creation
     * */
    public function postCreation(array $data=[]){
        $this->type='POST';
        $this->path='/v2/sub-user/creation';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /v2/sub-user/user-list
     * */
    public function getUserList(array $data=[]){
        $this->type='GET';
        $this->path='/v2/sub-user/user-list';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *POST /v2/sub-user/management
     * */
    public function getManagement(array $data=[]){
        $this->type='POST';
        $this->path='/v2/sub-user/management';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /v2/sub-user/user-state
     * */
    public function getUserState(array $data=[]){
        $this->type='GET';
        $this->path='/v2/sub-user/user-state';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *POST /v2/sub-user/tradable-market
     * */
    public function postTradableMarket(array $data=[]){
        $this->type='POST';
        $this->path='/v2/sub-user/tradable-market';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *POST /v2/sub-user/transferability
     * */
    public function postTransferability(array $data=[]){
        $this->type='POST';
        $this->path='/v2/sub-user/transferability';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /v2/sub-user/account-list
     * */
    public function getAccountList(array $data=[]){
        $this->type='GET';
        $this->path='/v2/sub-user/account-list';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *POST /v2/sub-user/api-key-generation
     * */
    public function postApiKeyGeneration(array $data=[]){
        $this->type='POST';
        $this->path='/v2/sub-user/api-key-generation';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /v2/user/api-key
     * */
    public function getApiKey(array $data=[]){
        $this->type='GET';
        $this->path='/v2/user/api-key';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *POST /v2/sub-user/api-key-modification
     * */
    public function postApiKeyModification(array $data=[]){
        $this->type='POST';
        $this->path='/v2/sub-user/api-key-modification';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *POST /v2/sub-user/api-key-deletion
     * */
    public function getApiKeyDeletion(array $data=[]){
        $this->type='POST';
        $this->path='/v2/sub-user/api-key-deletion';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *POST /v1/subuser/transfer
     * */
    public function postTransfer(array $data=[]){
        $this->type='POST';
        $this->path='/v1/subuser/transfer';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /v2/sub-user/deposit-address
     * */
    public function getDepositAddress(array $data=[]){
        $this->type='GET';
        $this->path='/v2/sub-user/deposit-address';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /v2/sub-user/query-deposit
     * */
    public function getQueryDeposit(array $data=[]){
        $this->type='GET';
        $this->path='/v2/sub-user/query-deposit';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /v1/subuser/aggregate-balance
     * */
    public function getAggregateBalance(array $data=[]){
        $this->type='GET';
        $this->path='/v1/subuser/aggregate-balance';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /v1/account/accounts/{sub-uid}
     * */
    public function getAccounts(array $data=[]){
        $this->type='GET';
        $this->path='/v1/account/accounts/'.$data['sub_uid'];
        $this->data=$data;
        return $this->exec();
    }
}