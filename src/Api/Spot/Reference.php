<?php

namespace Lin\Huobi\Api\Spot;

use Lin\Huobi\Request;

class Reference extends Request
{
    /**
     *
     * */
    public function getCurrencies(array $data=[]){
        $this->type='GET';
        $this->path='/v2/reference/currencies';
        $this->data=$data;
        return $this->exec();
    }

    /**
     *
     * */
    public function getTransactFeeRate(array $data=[]){
        $this->type='GET';
        $this->path='/v2/reference/transact-fee-rate';
        $this->data=$data;
        return $this->exec();
    }
}