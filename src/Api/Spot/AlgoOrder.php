<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Spot;



use Lin\Huobi\Request;

class AlgoOrder extends Request
{
    
    /**
     * POST /v2/algo-orders
     * */
    public function post(array $data=[]){
        $this->type='POST';
        $this->path='/v2/algo-orders';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * POST /v2/algo-orders/cancellation
     * */
    public function postCancellation(array $data=[]){
        $this->type='POST';
        $this->path='/v2/algo-orders/cancellation';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * GET /v2/algo-orders/opening
     * */
    public function getOpening(array $data=[]){
        $this->type='GET';
        $this->path='/v2/algo-orders/opening';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * GET /v2/algo-orders/history
     * */
    public function getHistory(array $data=[]){
        $this->type='GET';
        $this->path='/v2/algo-orders/history';
        $this->data=$data;
        return $this->exec();
    }
}