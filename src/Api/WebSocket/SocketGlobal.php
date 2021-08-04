<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\WebSocket;

use GlobalData\Server;
use GlobalData\Client;

trait SocketGlobal
{
    protected $server;
    protected $client;

    private $config=[];

    private function port(){
        $temp=is_array($this->config['platform']) ? $this->config['platform']['type'] : $this->config['platform'];

        switch ($temp){
            case 'option':{
                return '2215';
            }
            case 'linear':{
                return '2214';
            }
            case 'swap':{
                return '2213';
            }
            case 'future':{
                return '2212';
            }
            default:{//spot
                return '2211';
            }
        }
    }

    protected function server(){
        $address=isset($this->config['global']) ? explode(':',$this->config['global']) : ['0.0.0.0',$this->port()];
        $this->server=new Server($address[0],$address[1]);
        return $this;
    }

    protected function client(){
        $address=isset($this->config['global']) ? $this->config['global'] : '0.0.0.0:'.$this->port();
        $this->client=new Client($address);
        return $this;
    }

    protected function add($key,$value){
        $this->client->add($key,$value);

        $this->saveGlobalKey($key);
    }

    protected function get($key){
        if(!isset($this->client->$key) || empty($this->client->$key)) return [];
        return $this->client->$key;
    }

    protected function save($key,$value){
        if(!isset($this->client->$key)) $this->add($key,$value);
        else $this->client->$key=$value;
    }

    /**
     * 对了获取数据
     * @param $key
     * @return array
     */
    protected function getQueue($key){
        if(!isset($this->client->$key) || empty($this->client->$key)) return [];

        do{
            $old_value=$new_value=$this->client->$key;

            if(empty($new_value)) return [];
            //队列先进先出。
            $value=array_shift($new_value);
        }
        while(!$this->client->cas($key, $old_value, $new_value));

        return $value;
    }

    /**
     * 队列保存数据
     * @param $key
     * @param $value
     */
    protected function saveQueue($key,$value){
        //最大存储数据量，超过后保留一条最新的数据，其余数据全部删除。
        $max= isset($this->config['queue_count']) ? $this->config['queue_count'] : 100;

        if(!isset($this->client->$key)) $this->add($key,[$value]);
        else {
            do{
                $old_value=$new_value=$this->client->$key;

                //超过最大数据量，保留最新数据
                if(count($new_value)>$max){
                    $new_value=[$value];
                }else{
                    array_push($new_value,$value);
                }
            }
            while(!$this->client->cas($key, $old_value, $new_value));
        }
    }

    protected function addSubUpdate($data=[]){

        do{
            $old_value=$new_value=$this->client->add_sub;

            if(empty($data)){
                foreach ($new_value as $k=>$v){
                    unset($new_value[$k]);
                }
            }else{
                foreach ($new_value as $k=>$v){
                    foreach ($data as $dk=>$dv){
                        if($v[0]==$dv[0] && $v[1]['key']==$dv[1]['key']){
                            unset($data[$dk]);
                            unset($new_value[$k]);
                        }
                    }
                }
            }
        }
        while(!$this->client->cas('add_sub', $old_value, $new_value));
    }

    protected function delSubUpdate($data=[]){
        do{
            $old_value=$new_value=$this->client->del_sub;
            /*print_r($old_value);
            print_r($data);*/
            foreach ($data as $k=>$v){
                if(count($v)>1){
                    foreach ($new_value as $ok=>$ov){
                        if($v[0]==$ov[0] && $v[1]['key']==$ov[1]['key']) {
                            unset($new_value[$ok]);
                        }
                    }
                }else{
                    foreach ($new_value as $ok=>$ov) {
                        if ($v[0] == $ov[0]) unset($new_value[$ok]);
                    }
                }
            }
        }
        while(!$this->client->cas('del_sub', $old_value, $new_value));
    }

    protected function allSubUpdate($data,$type='add'){
        do{
            $old_value=$new_value=$this->client->all_sub;
            /*print_r($old_value);
            print_r($data);*/
            foreach ($data as $v){
                switch ($type){
                    case 'add':{
                        if(count($v)>1){
                            //数据格式
                            /*$v=[
                                [
                                    'orders.btc',
                                    ['key','keysecret']
                                ]
                            ];*/
                            $key=$v[1]['key'];
                            $value=[$this->userKey($v[1],strtolower($v[0]))];
                            if(!isset($new_value[$key])) $new_value[$key]=$value;
                            else $new_value[$key]=array_unique(array_merge($new_value[$key],$value));
                        }else{
                            $new_value[$v[0]]=$v[0];
                        }
                        break;
                    }
                    case 'del':{
                        if(count($v)>1){
                            $key=$v[1]['key'];
                            $value=$this->userKey($v[1],strtolower($v[0]));

                            //删除单个用户订阅删除
                            foreach ($new_value[$key] as $k=>$v){
                                if($v==$value) unset($new_value[$key][$k]);
                            }

                            //如果该用户没有删除数据 则直接删除整个数据
                            if(empty($new_value[$key])) unset($new_value[$key]);
                        }else{
                            unset($new_value[$v[0]]);
                        }
                        break;
                    }
                }
            }

        }
        while(!$this->client->cas('all_sub', $old_value, $new_value));
    }

    protected function keysecretInit($keysecret,$data=[]){
        do {
            $old_value = $new_value = $this->client->keysecret;

            if(empty($data)) {
                $new_value[$keysecret['key']]=[];
            }else{
                if(isset($new_value[$keysecret['key']])) $new_value[$keysecret['key']]=array_merge($new_value[$keysecret['key']],$keysecret);
                else $new_value[$keysecret['key']]=$keysecret;

                if(!empty($data)){
                    foreach ($data as $k=>$v){
                        $new_value[$keysecret['key']][$k]=$v;
                    }
                }
            }
        }
        while(!$this->client->cas('keysecret', $old_value, $new_value));
    }

    protected function saveGlobalKey($key){
        do {
            $old_value = $new_value = $this->client->global_key;
            $new_value[$key]=$key;
        }
        while(!$this->client->cas('global_key', $old_value, $new_value));
    }

    /**
     * Huobi
     */
    protected function getId(){
        list($msec, $sec) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000).rand(1000,9999);
    }
}
