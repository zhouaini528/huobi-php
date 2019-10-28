<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\Futures;



use Lin\Huobi\Request;

class Lightning extends Request
{
    /**
     * POST api/v1/lightning_close_position
     * */
    public function postClosePosition(array $data){
        $this->type='POST';
        $this->path='/api/v1/lightning_close_position';
        
        $this->data=$data;
        return $this->exec();
    }
}