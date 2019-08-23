<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi;

use GuzzleHttp\Exception\RequestException;
use Lin\Huobi\Exceptions\Exception;

class Request
{
    protected $key='';
    
    protected $secret='';
    
    protected $host='';
    
    protected $account_id='';
    
    
    
    protected $nonce='';
    
    protected $signature='';
    
    protected $headers=[];
    
    protected $type='';
    
    protected $path='';
    
    protected $data=[];
    
    protected $options=[];
    
    public function __construct(array $data)
    {
        $this->key=$data['key'] ?? '';
        $this->secret=$data['secret'] ?? '';
        $this->host=$data['host'] ?? 'https://api.huobi.pro';
        
        $this->options=$data['options'] ?? [];
    }
    
    /**
     * 认证
     * */
    protected function auth(){
        $this->nonce();
        
        $this->signature();
        
        $this->headers();
        
        $this->options();
    }
    
    /**
     * 过期时间
     * */
    protected function nonce(){
        $this->nonce=gmdate('Y-m-d\TH:i:s');
    }
    
    /**
     * 签名
     * */
    protected function signature(){
        $param = [
            'AccessKeyId' => $this->key,
            'SignatureMethod' => 'HmacSHA256',
            'SignatureVersion' => 2,
            'Timestamp' => $this->nonce,
        ];
        
        if(!empty($this->data)) {
            $param=array_merge($param,$this->data);
        }
        
        $param=$this->sort($param);
        
        $host_tmp=explode('https://', $this->host);
        if(isset($host_tmp[1])) $temp=$this->type . "\n" . $host_tmp[1] . "\n" . $this->path . "\n" . implode('&', $param);
        $signature=base64_encode(hash_hmac('sha256', $temp ?? '', $this->secret, true));
        
        $param[]="Signature=" . urlencode($signature);
        
        $this->signature=implode('&', $param);
    }
    
    /**
     * 根据huobi规则排序
     * */
    protected function sort($param)
    {
        $u = [];
        $sort_rank = [];
        foreach ($param as $k => $v) {
            $u[] = $k . "=" . urlencode($v);
            $sort_rank[] = ord($k);
        }
        asort($u);
        
        return $u;
    }
    
    /**
     * 默认头部信息
     * */
    protected function headers(){
        $this->headers=[
            'Content-Type' => 'application/json',
        ];
    }
    
    /**
     * 请求设置
     * */
    protected function options(){
        $this->options=array_merge([
            'headers'=>$this->headers,
            //'verify'=>false   //关闭证书认证
        ],$this->options);
        
        $this->options['timeout'] = $this->options['timeout'] ?? 60;
        
        if(isset($this->options['proxy']) && $this->options['proxy']===true) {
            $this->options['proxy']=[
                'http'  => 'http://127.0.0.1:12333',
                'https' => 'http://127.0.0.1:12333',
                'no'    =>  ['.cn']
            ];
        }
    }
    
    /**
     * 发送http
     * */
    protected function send(){
        $client = new \GuzzleHttp\Client();
        
        if(!empty($this->data)) {
            $this->options['body']=json_encode($this->data);
        }
        
        $response = $client->request($this->type, $this->host.$this->path.'?'.$this->signature, $this->options);
        
        return $response->getBody()->getContents();
    }
    
    /*
     * 执行流程
     * */
    protected function exec(){
        $this->auth();
        
        //可以记录日志
        try {
            $temp=json_decode($this->send(),true);
            if(isset($temp['status']) && $temp['status']=='error') {
                $temp['_method']=$this->type;
                $temp['_url']=$this->host.$this->path;
                $temp['_httpcode']=200;
                throw new Exception(json_encode($temp));
            }
            
            return $temp;
        }catch (RequestException $e){
            if(method_exists($e->getResponse(),'getBody')){
                $contents=$e->getResponse()->getBody()->getContents();
                
                $temp=json_decode($contents,true);
                if(!empty($temp)) {
                    $temp['_method']=$this->type;
                    $temp['_url']=$this->host.$this->path;
                }else{
                    $temp['_message']=$e->getMessage();
                }
            }else{
                $temp['_message']=$e->getMessage();
            }
            
            $temp['_httpcode']=$e->getCode();
            
            //TODO  该流程可以记录各种日志
            throw new Exception(json_encode($temp));
        }
    }
}