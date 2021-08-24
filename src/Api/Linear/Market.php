<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Linear;



use Lin\Huobi\Request;

class Market extends Request
{

    /**
     *GET linear-swap-api/v1/swap_contract_info
     * */
    public function getContractInfo(array $data=[]){
        $this->type='GET';
        $this->path='/linear-swap-api/v1/swap_contract_info';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *GET linear-swap-api/v1/swap_index
     * */
    public function getIndex(array $data=[]){
        $this->type='GET';
        $this->path='/linear-swap-api/v1/swap_index';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *GET linear-swap-api/v1/swap_price_limit
     * */
    public function getPriceLimit(array $data=[]){
        $this->type='GET';
        $this->path='/linear-swap-api/v1/swap_price_limit';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *GET linear-swap-api/v1/swap_open_interest
     * */
    public function getOpenInterest(array $data=[]){
        $this->type='GET';
        $this->path='/linear-swap-api/v1/swap_open_interest';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *GET linear-swap-ex/market/depth
     * */
    public function getDepth(array $data=[]){
        $this->type='GET';
        $this->path='/linear-swap-ex/market/depth';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *GET linear-swap-ex/market/history/kline
     * */
    public function getHistoryKline(array $data=[]){
        $this->type='GET';
        $this->path='/linear-swap-ex/market/history/kline';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *GET linear-swap-ex/market/detail/merged
     * */
    public function getDetailMerged(array $data=[]){
        $this->type='GET';
        $this->path='/linear-swap-ex/market/detail/merged';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *GET linear-swap-ex/market/trade
     * */
    public function getTrade(array $data=[]){
        $this->type='GET';
        $this->path='/linear-swap-ex/market/trade';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *GET linear-swap-ex/market/history/trade
     * */
    public function getHistoryTrade(array $data=[]){
        $this->type='GET';
        $this->path='/linear-swap-ex/market/history/trade';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *GET linear-swap-api/v1/swap_risk_info
     * */
    public function getRiskInfo(array $data=[]){
        $this->type='GET';
        $this->path='/linear-swap-api/v1/swap_risk_info';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *GET linear-swap-api/v1/swap_insurance_fund
     * */
    public function getInsuranceFund(array $data=[]){
        $this->type='GET';
        $this->path='/linear-swap-api/v1/swap_insurance_fund';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *GET linear-swap-api/v1/swap_adjustfactor
     * */
    public function getAdjustfactor(array $data=[]){
        $this->type='GET';
        $this->path='/linear-swap-api/v1/swap_adjustfactor';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *GET linear-swap-api/v1/swap_his_open_interest
     * */
    public function getHisOpenInterest(array $data=[]){
        $this->type='GET';
        $this->path='/linear-swap-api/v1/swap_his_open_interest';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *GET linear-swap-api/v1/swap_elite_account_ratio
     * */
    public function getEliteAccountRatio(array $data=[]){
        $this->type='GET';
        $this->path='/linear-swap-api/v1/swap_elite_account_ratio';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *GET linear-swap-api/v1/swap_elite_position_ratio
     * */
    public function getElitePositionRatio(array $data=[]){
        $this->type='GET';
        $this->path='/linear-swap-api/v1/swap_elite_position_ratio';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *GET linear-swap-api/v1/swap_api_state
     * */
    public function getApiState(array $data=[]){
        $this->type='GET';
        $this->path='/linear-swap-api/v1/swap_api_state';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *GET linear-swap-api/v1/swap_funding_rate
     * */
    public function getFundingRate(array $data=[]){
        $this->type='GET';
        $this->path='/linear-swap-api/v1/swap_funding_rate';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *GET linear-swap-api/v1/swap_batch_funding_rate
     * */
    public function getBatchFundingRate(array $data=[]){
        $this->type='GET';
        $this->path='/linear-swap-api/v1/swap_batch_funding_rate';
        $this->data=$data;
        return $this->exec();
    }

    /**
     *GET linear-swap-api/v1/swap_historical_funding_rate
     * */
    public function getHistoricalFundingRate(array $data=[]){
        $this->type='GET';
        $this->path='/linear-swap-api/v1/swap_historical_funding_rate';
        $this->data=$data;
        return $this->exec();
    }

    /**
     *GET linear-swap-api/v1/swap_liquidation_orders
     * */
    public function getLiquidationOrders(array $data=[]){
        $this->type='GET';
        $this->path='/linear-swap-api/v1/swap_liquidation_orders';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *GET /index/market/history/linear_swap_premium_index_kline
     * */
    public function getHistoryLinearSwapPremiumIndexKline(array $data=[]){
        $this->type='GET';
        $this->path='/index/market/history/linear_swap_premium_index_kline';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *GET /index/market/history/linear_swap_estimated_rate_kline
     * */
    public function getHistoryLinearSwapEstimatedRateKline(array $data=[]){
        $this->type='GET';
        $this->path='/index/market/history/linear_swap_estimated_rate_kline';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *GET index/market/history/linear_swap_basis
     * */
    public function getHistoryLinearSwapBasis(array $data=[]){
        $this->type='GET';
        $this->path='/index/market/history/linear_swap_basis';

        $this->data=$data;
        return $this->exec();
    }
}
