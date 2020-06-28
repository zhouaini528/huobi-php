<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Spot;



use Lin\Huobi\Request;

class Order extends Request
{
    /**
     *POST /v1/order/orders/place
     * */
    public function postPlace(array $data=[]){
        $this->type='POST';
        $this->path='/v1/order/orders/place';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *POST /v1/order/batch-orders
     * */
    public function postBatchOrders(array $data=[]){
        $this->type='POST';
        $this->path='/v1/order/batch-orders';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * POST /v1/order/orders/{order-id}/submitcancel
     * */
    public function postSubmitCancel(array $data=[]){
        $this->type='POST';
        $this->path='/v1/order/orders/'.$data['order-id'].'/submitcancel';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * POST /v1/order/orders/submitCancelClientOrder
     * */
    public function postSubmitCancelClientOrder(array $data=[]){
        $this->type='POST';
        $this->path='/v1/order/orders/submitCancelClientOrder';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /v1/order/openOrders 
     * */
    public function getOpenOrders(array $data=[]){
        $this->type='GET';
        $this->path='/v1/order/openOrders';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *POST /v1/order/orders/batchCancelOpenOrders
     * */
    public function postBatchCancelOpenOrders(array $data=[]){
        $this->type='GET';
        $this->path='/v1/order/orders/batchCancelOpenOrders';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *POST /v1/order/orders/batchcancel
     * */
    public function postBatchCancel(array $data=[]){
        $this->type='GET';
        $this->path='/v1/order/orders/batchcancel';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /v1/order/orders/{order-id}
     * */
    public function get(array $data=[]){
        $this->type='GET';
        $this->path='/v1/order/orders/'.$data['order-id'];
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * GET /v1/order/orders/getClientOrder
     * */
    public function getClientOrder(array $data=[]){
        $this->type='GET';
        $this->path='/v1/order/orders/getClientOrder';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * GET /v1/order/orders/{order-id}/matchresults
     * */
    public function getMatchresults(array $data=[]){
        $this->type='GET';
        $this->path='/v1/order/orders/{order-id}/matchresults';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * GET /v1/order/orders
     * */
    public function getOrders(array $data=[]){
        $this->type='GET';
        $this->path='/v1/order/orders';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * GET /v1/order/history
     * */
    public function getHistory(array $data=[]){
        $this->type='GET';
        $this->path='/v1/order/history';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * GET /v1/order/matchresults
     * */
    public function getMatchresultsAll(array $data=[]){
        $this->type='GET';
        $this->path='/v1/order/matchresults';
        $this->data=$data;
        return $this->exec();
    }
}