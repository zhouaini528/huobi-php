<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Swap;



use Lin\Huobi\Request;

class Account extends Request
{
    /**
     * 读取	账户接口	swap-api/v1/swap_account_info	POST	获取用户账户信息	是
     * */
    public function postAccountInfo(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_account_info';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	账户接口	swap-api/v1/swap_position_info	POST	获取用户持仓信息	是
     * */
    public function postPositionInfo(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_position_info';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	账户接口	swap-api/v1/swap_sub_account_list	POST	查询母账户下所有子账户资产信息	是
     * */
    public function postSubAccountList(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_sub_account_list';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	账户接口	swap-api/v1/swap_sub_account_info	POST	查询单个子账户资产信息	是
     * */
    public function postSubAccountInfo(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_sub_account_info';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	账户接口	swap-api/v1/swap_sub_position_info	POST	查询单个子账户持仓信息	是
     * */
    public function postSubPositionInfo(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_sub_position_info';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	账户接口	swap-api/v1/swap_financial_record	POST	查询用户财务记录	是
     * */
    public function postFinancialRecord(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_financial_record';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	账户接口	swap-api/v1/swap_order_limit	POST	查询用户当前的下单量限制	是
     * */
    public function postOrderLimit(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_order_limit';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	账户接口	swap-api/v1/swap_fee	POST	查询用户当前的手续费费率	是
     * */
    public function postFee(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_fee';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	账户接口	swap-api/v1/swap_transfer_limit	POST	查询用户当前的划转限制	是
     * */
    public function postTransferLimit(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_transfer_limit';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *读取	账户接口	swap-api/v1/swap_position_limit	POST	用户持仓量限制的查询	是
     * */
    public function postPositionLimit(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_position_limit';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *交易	账户接口	swap-api/v1/swap_order	POST	合约下单	是
     * */
    public function postOrder(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_order';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *交易	账户接口	swap-api/v1/swap_batchorder	POST	合约批量下单	是
     * */
    public function postBatchorder(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_batchorder';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *交易	账户接口	swap-api/v1/swap_cancel	POST	撤销订单	是
     * */
    public function postCancel(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_cancel';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *交易	账户接口	swap-api/v1/swap_cancelall	POST	全部撤单	是
     * */
    public function postCancelall(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_cancelall';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *交易	账户接口	swap-api/v1/swap_order_info	POST	获取合约订单信息	是
     * */
    public function posOrderInfo(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_order_info';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *交易	账户接口	swap-api/v1/swap_order_detail	POST	获取订单明细信息	是
     * */
    public function postOrderDetail(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_order_detail';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *交易	账户接口	swap-api/v1/swap_openorders	POST	获取合约当前未成交委托	是
     * */
    public function postOpenorders(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_openorders';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *交易	账户接口	swap-api/v1/swap_hisorders	POST	获取合约历史委托	是
     * */
    public function postHisorders(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_hisorders';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *交易	账户接口	swap-api/v1/swap_matchresults	POST	获取历史成交记录	是
     * */
    public function postMatchresults(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_matchresults';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *交易	账户接口	swap-api/v1/swap_lightning_close_position	POST	闪电平仓下单	是
     * */
    public function postLightningClosePosition(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_lightning_close_position';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *交易	账户接口	swap-api/v1/swap_liquidation_orders	POST	获取强平订单	是
     * */
    public function postLiquidationOrders(array $data=[]){
        $this->type='POST';
        $this->path='/swap-api/v1/swap_liquidation_orders';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *
     * */
    /* public function post(array $data=[]){
        $this->type='POST';
        $this->path='';
        
        $this->data=$data;
        return $this->exec();
    } */
}