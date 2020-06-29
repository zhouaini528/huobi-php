<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Spot;



use Lin\Huobi\Request;

class Market extends Request
{
    /**
     *GET /market/history/kline
     * */
    public function getHistoryKline(array $data=[]){
        $this->type='GET';
        $this->path='/market/history/kline';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /market/detail/merged
     * */
    public function getDetailMerged(array $data=[]){
        $this->type='GET';
        $this->path='/market/detail/merged';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /market/tickers
     * */
    public function getTickers(){
        $this->type='GET';
        $this->path='/market/tickers';
        return $this->exec();
    }
    
    /**
     * GET /market/depth
     * */
    public function getDepth(array $data=[]){
        $this->type='GET';
        $this->path='/market/depth';
        
        $data['type'] = $data['type'] ?? 'step0';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /market/trade
     * */
    public function getTrade(array $data=[]){
        $this->type='GET';
        $this->path='/market/trade';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *GET /market/history/trade
     * */
    public function getHistoryTrade(array $data=[]){
        $this->type='GET';
        $this->path='/market/history/trade';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * GET /market/detail
     * */
    public function getDetail(array $data=[]){
        $this->type='GET';
        $this->path='/market/detail';
        $this->data=$data;
        return $this->exec();
    }
}