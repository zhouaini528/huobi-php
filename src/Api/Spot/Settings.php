<?php

namespace Lin\Huobi\Api\Spot;

use Lin\Huobi\Request;

class Settings extends Request
{
    /**
     *
     * */
    public function getChains(array $data=[]){
        $this->type='GET';
        $this->path='/v1/settings/common/chains';
        $this->data=$data;
        return $this->exec();
    }

    /**
     *
     * */
    public function getCurrencies(array $data=[]){
        $this->type='GET';
        $this->path='/v2/settings/common/currencies';
        $this->data=$data;
        return $this->exec();
    }

    /**
     *
     * */
    public function getSymbols(array $data=[]){
        $this->type='GET';
        $this->path='/v2/settings/common/symbols';
        $this->data=$data;
        return $this->exec();
    }
}