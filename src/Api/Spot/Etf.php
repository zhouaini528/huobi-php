<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Spot;



use Lin\Huobi\Request;

class Etf extends Request
{
    /**
     *GET /etf/swap/config
     * */
    public function getSwapConfig(array $data=[]){
        $this->type='GET';
        $this->path='/etf/swap/config';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *POST /etf/swap/in
     * */
    public function postSwapIn(array $data=[]){
        $this->type='POST';
        $this->path='/etf/swap/in';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *POST /etf/swap/out
     * */
    public function postSwapOut(array $data=[]){
        $this->type='POST';
        $this->path='/etf/swap/out';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /etf/swap/list
     * */
    public function getList(array $data=[]){
        $this->type='GET';
        $this->path='/etf/swap/list';
        $this->data=$data;
        return $this->exec();
    }
}