<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Swap;



use Lin\Huobi\Request;

class Market extends Request
{
    /**
     * 读取	基础行情接口	swap-api/v1/swap_contract_info	GET	获取合约信息	否
     * */
    public function getContractInfo(array $data=[]){
        $this->type='GET';
        $this->path='/swap-api/v1/swap_contract_info';
        
        $this->data=$data;
        return $this->exec();
    }
    
    
    /**
     * 读取	基础行情接口	swap-api/v1/swap_index	GET	获取合约指数信息	否
     * */
    public function getIndex(array $data=[]){
        $this->type='GET';
        $this->path='/swap-api/v1/swap_index';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * 读取	基础行情接口	swap-api/v1/swap_price_limit	GET	获取合约最高限价和最低限价	否
     * */
    public function getPriceLimit(array $data=[]){
        $this->type='GET';
        $this->path='/swap-api/v1/swap_price_limit';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	基础行情接口	swap-api/v1/swap_open_interest	GET	获取当前可用合约总持仓量	否
     * */
    public function getOpenInterest(array $data=[]){
        $this->type='GET';
        $this->path='/swap-api/v1/swap_open_interest';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	市场行情接口	swap-ex/market/depth	GET	获取行情深度数据	否
     * */
    public function getDepath(array $data=[]){
        $this->type='GET';
        $this->path='/swap-ex/market/depth';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	市场行情接口	swap-ex/market/history/kline	GET	获取K线数据	否
     * */
    public function getHistorykline(array $data=[]){
        $this->type='GET';
        $this->path='/swap-ex/market/history/kline';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	市场行情接口	swap-ex/market/detail/merged	 GET	获取聚合行情	否
     * */
    public function getDetailMerged(array $data=[]){
        $this->type='GET';
        $this->path='/swap-ex/market/detail/merged';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	市场行情接口	swap-ex/market/trade	GET	获取市场最近成交记录	否
     * */
    public function getTrade(array $data=[]){
        $this->type='GET';
        $this->path='/swap-ex/market/trade';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	市场行情接口	swap-api/v1/swap_risk_info	GET	查询合约风险准备金余额和预估分摊比例	否
     * */
    public function getRiskInfo(array $data=[]){
        $this->type='GET';
        $this->path='/swap-api/v1/swap_risk_info';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	市场行情接口	swap-api/v1/swap_insurance_fund	GET	查询合约风险准备金余额历史数据	否
     * */
    public function getIinsuranceFund(array $data=[]){
        $this->type='GET';
        $this->path='/swap-api/v1/swap_insurance_fund';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	市场行情接口	swap-api/v1/swap_adjustfactor	GET	查询平台阶梯调整系数	否
     * */
    public function getAdjustfactor(array $data=[]){
        $this->type='GET';
        $this->path='/swap-api/v1/swap_adjustfactor';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	市场行情接口	swap-api/v1/swap_his_open_interest	GET	平台持仓量的查询	否
     * */
    public function getHisOpenInterest(array $data=[]){
        $this->type='GET';
        $this->path='/swap-api/v1/swap_his_open_interest';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	市场行情接口	swap-api/v1/swap_elite_account_ratio	GET	精英账户多空持仓对比-账户数	否
     * */
    public function getEliteAccountRatio(array $data=[]){
        $this->type='GET';
        $this->path='/swap-api/v1/swap_elite_account_ratio';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	市场行情接口	swap-api/v1/swap_elite_position_ratio	GET	精英账户多空持仓对比-持仓量	否
     * */
    public function getElitePositionRatio(array $data=[]){
        $this->type='GET';
        $this->path='/swap-api/v1/swap_elite_position_ratio';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	市场行情接口	swap-api/v1/swap_api_state	GET	查询系统状态	否
     * */
    public function getApiState(array $data=[]){
        $this->type='GET';
        $this->path='/swap-api/v1/swap_api_state';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	市场行情接口	swap-api/v1/swap_funding_rate	GET	获取合约的资金费率	否
     * */
    public function getFundingRate(array $data=[]){
        $this->type='GET';
        $this->path='/swap-api/v1/swap_funding_rate';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	市场行情接口	swap-api/v1/swap_historical_funding_rate	GET	获取合约的历史资金费率	否
     * */
    public function getHistoricalFundingRate(array $data=[]){
        $this->type='GET';
        $this->path='/swap-api/v1/swap_historical_funding_rate';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	市场行情接口	/heartbeat	GET	查询系统是否可用	否
     * */
    public function getHeartbeat(array $data=[]){
        $this->type='GET';
        $this->path='/heartbeat';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *
     * */
    /* public function get(array $data=[]){
        $this->type='GET';
        $this->path='';
        
        $this->data=$data;
        return $this->exec();
    } */
}