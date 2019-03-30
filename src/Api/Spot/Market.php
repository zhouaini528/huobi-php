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
     * 获取 Market Depth 数据
     * 参数名称	是否必须	类型	描述	默认值	取值范围
        symbol	true	string	交易对		btcusdt, bchbtc, rcneth ...
        type	true	string	Depth 类型		step0, step1, step2, step3, step4, step5（合并深度0-5）；step0时，不合并深度
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