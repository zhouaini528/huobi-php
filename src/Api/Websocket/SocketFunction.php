<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\WebSocket;


trait SocketFunction
{
    /**
     * @param array $sub
     * @return array
     */
    protected function resub(array $sub=[]){
        $new_sub=[];
        $temp1=['account','position','order','trade.clearing'];
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

    /**
     * @param $global
     * @param $tag
     * @param $data
     * @param string $keysecret
     */
    protected function errorMessage($global,$tag,$data,$keysecret=''){
        $all_sub=$global->get('all_sub');
        if(empty($all_sub)) return;

        if($tag=='public') {
            //查询 message 是否包含了关键词。并把错误信息写入频道记录
            foreach ($all_sub as $k=>$v){
                if(is_array($v)) continue;
                $sub=strtolower($v);
                if(stristr(strtolower($data['message']),$v)!==false) $global->save($sub,$data);
            }
        }else{
            //如果是用户单独订阅，则该用户所有相关的订阅都显示该错误
            /*foreach ($all_sub as $k=>$v){
                if(!is_array($v)) continue;
                $sub=strtolower($v[0]);
                $global->add($keysecret['key'].$sub,$data);
            }*/
        }
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
        return $keysecret['key'].'='.$sub;
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

            print_r($keysecret);
            echo $temp.PHP_EOL;
            $signature=base64_encode(hash_hmac('sha256', $temp ?? '', $keysecret['secret'], true));

            return array_merge($param,[
                "authType"=>"api",
                "signature"=> $signature
            ]);
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

        if($tag != 'public' && $platform=='spot') return json_decode($data,true);

        $data=gzdecode($data);
        return json_decode($data,true);
    }
}
