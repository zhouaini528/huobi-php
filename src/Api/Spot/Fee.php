<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Spot;

use Lin\Huobi\Request;

class Fee extends Request
{
    /**
     * GET /v1/fee/fee-rate/get
     * 
     * symbols	string	true	NA	交易对，可多填，逗号分隔	如"btcusdt,ethusdt"
     * */
    public function getFeeRate(array $data=[]){
        $this->type='GET';
        $this->path='/v1/fee/fee-rate/get';
        
        $this->data=$data;
        
        return $this->exec();
    }
}