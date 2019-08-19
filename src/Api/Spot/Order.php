<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Spot;



use Lin\Huobi\Request;

class Order extends Request
{
    /**
     *
     * */
    public function postPlace(array $data){
        $this->type='POST';
        $this->path='/v1/order/orders/place';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * 交易	POST/v1/order/orders/{order-id}/submitcancel	POST	按order-id撤销一个订单	Y	Y
     * */
    public function postSubmitCancel(array $data){
        $this->type='POST';
        $this->path='/v1/order/orders/'.$data['order-id'].'/submitcancel';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * 撤销订单（基于client order ID）	POST /v1/order/orders/submitCancelClientOrder
     * 
     * 参数名称	是否必须	类型	描述	默认值	取值范围
        client-order-id	true	string	用户自编订单号	
     * */
    public function postSubmitCancelClientOrder(array $data){
        $this->type='POST';
        $this->path='/v1/order/orders/submitCancelClientOrder';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *
     * */
    public function postBatchCancel(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *
     * */
    public function postBatchCancelOpenOrders(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * 用户订单信息	GET /v1/order/orders/{order-id}	GET	根据order-id查询订单详情	Y	Y
     * */
    public function get(array $data){
        $this->type='GET';
        $this->path='/v1/order/orders/'.$data['order-id'];
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * 查询订单详情（基于client order ID）	GET /v1/order/orders/getClientOrder
     * 
     * 参数名称	是否必须	类型	描述	默认值	取值范围
        clientOrderId	true	string	用户自编订单号	
     * */
    public function getClientOrder(array $data){
        $this->type='GET';
        $this->path='/v1/order/orders/getClientOrder';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * 用户订单信息	GET /v1/order/orders	GET	查询用户当前委托、或历史委托订单 (up to 100)	Y	Y
     * */
    public function getAll(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * 用户订单信息	GET /v1/order/orders/{order-id}/matchresults	GET	根据order-id查询订单的成交明细	Y	Y
     * */
    public function getMatchresults(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * 用户订单信息	GET /v1/order/matchresults	GET	查询用户当前成交、历史成交	Y	Y
     * */
    public function getMatchresultsAll(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * 
     * */
    public function getOpenOrders(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
}