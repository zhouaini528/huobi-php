<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Swap;



use Lin\Huobi\Request;

class Account extends Request
{
    /**
     *POST swap-api/v1/swap_account_info
     * */
    public function postAccountInfo(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_account_info';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_position_info
     * */
    public function postPositionInfo(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_position_info';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *post swap-api/v1/swap_account_position_info
     * */
    public function postAccountPositionInfo(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_account_position_info';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_sub_account_list
     * */
    public function postSubAccountList(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_sub_account_list';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_sub_account_info
     * */
    public function postSubAccountInfo(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_sub_account_info';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_sub_position_info
     * */
    public function postSubPositionInfo(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_sub_position_info';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_financial_record
     * */
    public function postFinancialRecord(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_financial_record';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_user_settlement_records
     * */
    public function postUserSettlementRecords(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_user_settlement_records';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_available_level_rate
     * */
    public function postAvailableLevelRate(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_available_level_rate';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_order_limit
     * */
    public function postOrderLimit(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_order_limit';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_fee
     * */
    public function postFee(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_fee';

        $this->data=$data;
        return $this->exec();
    }


    /**
     *POST swap-api/v1/swap_transfer_limit
     * */
    public function postTransferLimit(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_transfer_limit';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *post swap-api/v1/swap_position_limit
     * */
    public function postPositionLimit(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_position_limit';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *post /swap-api/v1/swap_master_sub_transfer
     * */
    public function postMasterSubTransfer(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_master_sub_transfer';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *post /swap-api/v1/swap_master_sub_transfer_record
     * */
    public function postMasterSubTransferRecord(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_master_sub_transfer_record';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *get /swap-api/v1/swap_api_trading_status
     * */
    public function getApiTradingStatus(array $data=[]){
        $this->type='GET';
        $this->path='/swap-api/v1/swap_api_trading_status';

        $this->data=$data;
        return $this->exec();
    }
}
