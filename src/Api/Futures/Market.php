<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Futures;



use Lin\Huobi\Request;

class Market extends Request
{
    /**
     * 获取行情深度数据
     * symbol	string	true	如"BTC_CW"表示BTC当周合约，"BTC_NW"表示BTC次周合约，"BTC_CQ"表示BTC季度合约
        type	string	true	(150档数据) step0, step1, step2, step3, step4, step5（合并深度1-5）；
        step0时，不合并深度, (20档数据) step6, step7, step8, step9, step10, step11（合并深度7-11）；
        step6时，不合并深度
     * */
    public function getDepth(array $data=[]){
        $this->type='GET';
        $this->path='/market/depth';
        
        $data['type'] = $data['type'] ?? '';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * GET /market/history/kline
     * */
    public function getHistoryKline(array $data=[]){
        $this->type='GET';
        $this->path='/market/history/kline';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * GET /market/detail/merged
     * */
    public function getDetailMerged(array $data=[]){
        $this->type='GET';
        $this->path='/market/detail/merged';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * 获取市场最近成交记录
     * symbol	true	string	合约名称	如"BTC_CW"表示BTC当周合约，"BTC_NW"表示BTC次周合约，"BTC_CQ"表示BTC季度合约
     * */
    public function getTrade(array $data=[]){
        $this->type='GET';
        $this->path='/market/trade';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * 批量获取最近的交易记录
     * symbol	true	string	合约名称		如"BTC_CW"表示BTC当周合约，"BTC_NW"表示BTC次周合约，"BTC_CQ"表示BTC季度合约
        size	false	number	获取交易记录的数量	1	[1, 2000]
     * */
    public function getHistoryTrade(array $data=[]){
        $this->type='GET';
        $this->path='/market/history/trade';
        
        $data['size'] = $data['size'] ?? 200;
        
        $this->data=$data;
        return $this->exec();
    }
}