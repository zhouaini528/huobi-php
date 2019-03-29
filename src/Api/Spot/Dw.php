<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Spot;



use Lin\Huobi\Request;

class Dw extends Request
{
    /**
     * 充提币	POST /v1/dw/withdraw/api/create	POST	申请提币	Y	N
     * */
    public function postWithdrawApiCreate(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     * 充提币	POST /v1/dw/withdraw-virtual/{withdraw-id}/cancel	POST	撤销提币申请	Y	N
     * */
    public function postWithdrawVirtualCancel(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *
     * */
    public function postTransferInMargin(array $data){
        $this->type='GET';
        $this->path='';
        $this->data=$data;
        return $this->exec();
    }
    
    /**
     *
     * */
    public function postTransferOutMargin(array $data){
        $this->type='GET';
        $this->path='';
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