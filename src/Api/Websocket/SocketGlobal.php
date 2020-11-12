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
                        if($v[0]==$dv[0]){
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
            foreach ($new_value as $k=>$v){
                unset($new_value[$k]);
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
                        if(is_array($v)){
                            if(!isset($new_value[$v[0]])) $new_value[$v[0]]=$v[0];
                            else $new_value[$v[0]]=array_unique(array_merge($new_value[$v[0]],$v));
                        }else{
                            $new_value[$v[0]]=$v;
                        }
                        break;
                    }
                    case 'del':{
                        unset($new_value[$v[0]]);
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
