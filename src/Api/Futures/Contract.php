<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Futures;



use Lin\Huobi\Request;

class Contract extends Request
{
    /**
     * Restful	基础信息接口	api/v1/contract_contract_info	GET	获取合约信息	否
     * 
     * symbol	string	false	"BTC","ETH"...
        contract_type	string	false	合约类型: （this_week:当周 next_week:下周 quarter:季度）
        contract_code	string	false	BTC180914
     * */
    public function getContractInfo(array $data=[]){
        $this->type='GET';
        $this->path='/api/v1/contract_contract_info';
        $this->data=$data;
        return $this->exec();
    }
    
    public function getIndex(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    public function getPriceLimit(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    public function getOpenInterest(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    public function getDeliveryPrice(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * 获取用户账户信息
     * symbol	false	string	品种代码		"BTC","ETH"...如果缺省，默认返回所有品种
     * */
    public function postAccountInfo(array $data=[]){
        $this->type='POST';
        $this->path='/api/v1/contract_account_info';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * 获取用户持仓信息
     * symbol	false	string	品种代码		"BTC","ETH"...如果缺省，默认返回所有品种
     * */
    public function postPositionInfo(array $data=[]){
        $this->type='POST';
        $this->path='/api/v1/contract_position_info';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * 合约下单
     * 参数名	参数类型	必填	描述
        symbol	string	true	"BTC","ETH"...
        contract_type	string	true	合约类型 ("this_week":当周 "next_week":下周 "quarter":季度)
        contract_code	string	true	BTC180914
        client_order_id	long	false	客户自己填写和维护，这次一定要大于上一次
        price	decimal	true	价格
        volume	long	true	委托数量(张)
        direction	string	true	"buy":买 "sell":卖
        offset	string	true	"open":开 "close":平
        lever_rate	int	true	杠杆倍数[“开仓”若有10倍多单，就不能再下20倍多单]
        order_price_type	string	true	订单报价类型 "limit":限价 "opponent":对手价
     * */
    public function postOrder(array $data){
        $this->type='POST';
        $this->path='/api/v1/contract_order';
        
        $data['lever_rate']=$data['lever_rate'] ?? 10;
        $data['order_price_type']=$data['order_price_type'] ?? 'limit';
        
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * 
     * */
    public function postBatchOrder(array $data){
        $this->type='POST';
        $this->path='/api/v1/contract_batchorder';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * 撤销订单
        URL api/v1/contract_cancel
        
        参数名称	是否必须	类型	描述
        order_id	false	string	订单ID（ 多个订单ID中间以","分隔,一次最多允许撤消50个订单 ）
        client_order_id	false	string	客户订单ID(多个订单ID中间以","分隔,一次最多允许撤消50个订单)
        symbol	true	string	"BTC","ETH"...
     * */
    public function postCancel(array $data){
        $this->type='POST';
        $this->path='/api/v1/contract_cancel';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * symbol	true	string	品种代码，如"BTC","ETH"...
     * */
    public function postCancelAll(array $data){
        $this->type='POST';
        $this->path='/api/v1/contract_cancelall';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * 获取合约订单信息
     * order_id	 false	string	订单ID（ 多个订单ID中间以","分隔,一次最多允许查询20个订单 ）
        client_order_id	false	string	客户订单ID(多个订单ID中间以","分隔,一次最多允许查询20个订单)
        symbol	true	string	"BTC","ETH"...
     * */
    public function postOrderInfo(array $data){
        $this->type='POST';
        $this->path='/api/v1/contract_order_info';
        $this->data=$data;
        return $this->exec();
    }
    
    public function postOrderDetail(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    public function postOpenOrders(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    public function postHisorders(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
}