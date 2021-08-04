<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\WebSocket;


trait SocketFunction
{
    //标记分隔符
    static $USER_DELIMITER='===';

    /**
     * @param array $sub
     * @return array
     */
    protected function resub(array $sub=[]){
        $new_sub=[];

        $temp1=[
            'account',
            'position',
            'order',
            'trade.clearing',//spot

            //免加密 但是需要走用户通道
            'contract_info',
            'funding_rate'
        ];

        foreach ($sub as $v) {
            $temp2=[$v];
            foreach ($temp1 as $tv){
                if(strpos($v, $tv) !== false){
                    array_push($temp2,empty($this->keysecret)? [] : $this->keysecret);
                }
            }
            array_push($new_sub,$temp2);
        }

        return $new_sub;
    }

    protected function log($message){
        if (!is_string($message)) $message=json_encode($message);

        $time=time();
        $tiemdate=date('Y-m-d H:i:s',$time);

        $message=$tiemdate.' '.$message.PHP_EOL;

        if(isset($this->config['log'])){
            if(is_array($this->config['log']) && isset($this->config['log']['filename'])){
                $filename=$this->config['log']['filename'].'-'.date('Y-m-d',$time).'.txt';
            }else{
                $filename=date('Y-m-d',$time).'.txt';
            }

            file_put_contents($filename,$message,FILE_APPEND);
        }

        echo $message;
    }

    /**
     * 设置用户key
     * @param $keysecret
     */
    protected function userKey(array $keysecret,string $sub){
        return $keysecret['key'].self::$USER_DELIMITER.$sub;
    }

    /**
     * 根据huobi规则排序
     * */
    protected function sort($param)
    {
        $u = [];
        $sort_rank = [];
        foreach ($param as $k => $v) {
            if(is_array($v)) $v=json_encode($v);
            $u[] = $k . "=" . urlencode($v);
            $sort_rank[] = ord($k);
        }
        asort($u);

        return $u;
    }

    private function auth(string $host,array $keysecret){
        $platform=$this->getPlatform();

        if($platform=='spot'){
            $param = [
                'accessKey' => $keysecret['key'],
                'signatureMethod' => 'HmacSHA256',
                'signatureVersion' => '2.1',
                'timestamp' => gmdate('Y-m-d\TH:i:s'),
            ];
            //accessKey，signatureMethod，signatureVersion，timestamp
            $param_tmp=$this->sort($param);
            $host_tmp=explode('/', $host);
            if(isset($host_tmp[1])) $temp="GET\n" . $host_tmp[2] . "\n" . '/ws/v2' . "\n" . implode('&', $param_tmp);

            $signature=base64_encode(hash_hmac('sha256', $temp ?? '', $keysecret['secret'], true));

            $param['signature']=$signature;
            return array_merge(["authType"=>"api"],$param);
        }else{
            $param = [
                'AccessKeyId' => $keysecret['key'],
                'SignatureMethod' => 'HmacSHA256',
                'SignatureVersion' => '2',
                'Timestamp' => gmdate('Y-m-d\TH:i:s'),
            ];

            $param_tmp=$this->sort($param);

            $host_tmp=explode('/', $host);
            if(isset($host_tmp[1])) $temp="GET\n" . $host_tmp[2] . "\n/" . $host_tmp[3] . "\n" . implode('&', $param_tmp);

            $signature=base64_encode(hash_hmac('sha256', $temp ?? '', $keysecret['secret'], true));

            return array_merge($param,[
                "Signature"=> $signature
            ]);
        }
    }

    private function getPlatform(){
        $platform='spot';
        if(is_array($this->config['platform'])) $platform=$this->config['platform']['type'];
        else $platform=$this->config['platform'];

        return $platform;
    }

    /**
     * @param $tag
     * @param $data
     * @return array
     */
    private function getDecodeData($tag,$data){
        $platform=$this->getPlatform();

        if($tag != 'market' && $platform=='spot') return json_decode($data,true);

        $data=gzdecode($data);
        return json_decode($data,true);
    }

    /**
     * @param $sub
     * @return array
     */
    private function channelType($sub){
        $temp=['market'=>[],'kline'=>[],'private'=>[]];
        foreach ($sub as $k=>$v){
            if(count($v)>1) array_push($temp['private'],$v);
            else {
                //检测是否是kline 数据通道
                $kline_data=false;
                $kline_key=['index','basis','estimated_rate'];
                foreach ($kline_key as $kv){
                    if(strpos($v[0], $kv) !== false){
                        array_push($temp['kline'],$v);
                        $kline_data=true;
                    }
                }

                if(!$kline_data) array_push($temp['market'],$v);
            }
        }

        return $temp;
    }

    /**
     * 重新订阅
     */
    private function reconnection($global,$type='public',array $keysecret=[]){
        $all_sub=$global->get('all_sub');
        if(empty($all_sub)) return;

        if($type=='public'){
            $temp=[];
            foreach ($all_sub as $v){
                if(!is_array($v)) $temp[]=$v;
            }
        }else{
            $this->keysecret=$keysecret;

            $temp=[];
            foreach ($all_sub[$keysecret['key']] as $v){
                $t=explode(self::$USER_DELIMITER,$v);
                $temp[]=$t[1];
            }
        }

        $add_sub=$global->get('add_sub');
        if(empty($add_sub)) $global->save('add_sub',$this->resub($temp));
        else $global->save('add_sub',array_merge($this->resub($temp),$add_sub));
    }
}
