<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Swap;

use Lin\Huobi\Request;

class Trade extends Request
{
    /**
     *POST swap-api/v1/swap_order
     * */
    public function postOrder(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_order';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_batchorder
     * */
    public function postBatchOrder(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_batchorder';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_cancel
     * */
    public function postCancel(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_cancel';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_cancelall
     * */
    public function postCancelAll(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_cancelall';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_switch_lever_rate
     * */
    public function postSwitchLeverRate(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_switch_lever_rate';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_order_info
     * */
    public function postOrderInfo(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_order_info';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_order_detail
     * */
    public function postOrderDetail(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_order_detail';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_openorders
     * */
    public function postOpenOrders(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_openorders';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_hisorders
     * */
    public function postHisorders(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_hisorders';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_matchresults
     * */
    public function postMatchResults(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_matchresults';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_lightning_close_position
     * */
    public function postLightningClosePosition(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_lightning_close_position';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_trigger_order
     * */
    public function postTriggerOrder(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_trigger_order';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_trigger_cancel
     * */
    public function postTriggerCancel(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_trigger_cancel';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_trigger_cancelall
     * */
    public function postTriggerCancelall(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_trigger_cancelall';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_trigger_openorders
     * */
    public function postTriggerOpenorders(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_trigger_openorders';

        $this->data=$data;
        return $this->exec();
    }

    /**
     *POST swap-api/v1/swap_trigger_hisorders
     * */
    public function postTriggerHisorders(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_trigger_hisorders';

        $this->data=$data;
        return $this->exec();
    }
}
