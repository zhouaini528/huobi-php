<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Spot;

use Lin\Huobi\Request;

class Futures extends Request
{
    /**
     * POST /v1/futures/transfer
     * 
     * currency	string	true	NA	币种, e.g. btc	
        amount	decimal	true	NA	划转数量	
        type	string	true	NA	划转类型	从合约账户到现货账户：“futures-to-pro”，从现货账户到合约账户： “pro-to-futures”
     * */
    public function postTransfer(array $data=[]){
        $this->type='POST';
        $this->path='/v1/futures/transfer';
        
        $this->data=$data;
        
        return $this->exec();
    }
}