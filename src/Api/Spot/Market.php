<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Spot;



use Lin\Huobi\Request;

class Market extends Request
{
    /**
     *
     * */
    public function getHistoryKline(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *
     * */
    public function getDetailMerged(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *
     * */
    public function getTickers(){
        $this->type='GET';
        $this->path='/market/tickers';
        return $this->exec();
    }
    
    /**
     *
     * */
    public function getDepth(array $data){
        $this->type='GET';
        $this->path='/market/depth';
        
        $data['type'] = $data['type'] ?? 'step0';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *
     * */
    public function getTrade(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *
     * */
    public function getHistoryTrade(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * 
     * */
    public function getDetail(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
}