<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Huobi\Api\WebSocket;

use Lin\Huobi\Api\WebSocket\SocketGlobal;
use Lin\Huobi\Api\WebSocket\SocketFunction;
use Lin\Huobi\Exceptions\Exception;
use Workerman\Lib\Timer;
use Workerman\Worker;
use Workerman\Connection\AsyncTcpConnection;

class SocketServer
{
    use SocketGlobal;
    use SocketFunction;

    private $worker;

    private $connection=[];
    private $connectionIndex=0;
    private $config=[];

    private $public_url=['market','kline'];

    function __construct(array $config=[])
    {
        $this->config=$config;
    }

    public function start(){
        $this->worker = new Worker();
        $this->server();

        $this->worker->onWorkerStart = function() {
            $this->addConnection('market');
            //$this->addConnection('order');

            if(in_array($this->getPlatform(),['future','swap','linear'])) $this->addConnection('kline');

            //$this->addConnection('system');
        };

        Worker::runAll();
    }

    private function addConnection(string $tag,array $keysecret=[]){
        $this->newConnection()($tag,$keysecret);
    }

    private function getBaseUrl($tag,$keysecret){
        if(is_array($this->config['platform'])){
            if(!empty($keysecret)) return $this->config['platform']['order'];
            return $this->config['platform'][$tag];
        }

        switch ($this->config['platform']){
            case 'option':{
                if($tag=='market') return 'ws://api.hbdm.com/option-ws';;
                if(!empty($keysecret)) return 'ws://api.hbdm.com/option-notification';
            }
            case 'linear':{
                if($tag=='market') return 'ws://api.hbdm.com/linear-swap-ws';
                if(!empty($keysecret)) return 'ws://api.hbdm.com/linear-swap-notification';
            }
            case 'swap':{
                if($tag=='market') return 'ws://api.hbdm.com/swap-ws';
                if(!empty($keysecret)) return 'ws://api.hbdm.com/swap-notification';
            }
            case 'future':{
                if($tag=='market') return 'ws://api.hbdm.com/ws';
                if(!empty($keysecret)) return 'ws://api.hbdm.com/notification';
            }
            default:{//spot
                if($tag=='market') return 'ws://api.huobi.pro/ws';
                if(!empty($keysecret)) return 'ws://api.huobi.pro/ws/v2';
            }
        }

        if($tag=='kline') return 'ws://api.hbdm.com/ws_index';
        //if($tag=='system ') return 'ws://api.hbdm.com/center-notification';
    }

    private function newConnection(){
        return function($tag,$keysecret){
            $global=$this->client();

            $baseurl=$this->getBaseUrl($tag,$keysecret);

            $this->connection[$this->connectionIndex] = new AsyncTcpConnection($baseurl);
            $this->connection[$this->connectionIndex]->transport = 'ssl';

            $this->log('Connection '.$baseurl);

            //自定义属性
            $this->connection[$this->connectionIndex]->tag=$tag;//标记公共连接还是私有连接
            $this->connection[$this->connectionIndex]->tag_baseurl=$baseurl;
            if(!empty($keysecret)) $this->connection[$this->connectionIndex]->tag_keysecret=$keysecret;//标记私有连接

            $this->connection[$this->connectionIndex]->onConnect=$this->onConnect($keysecret);
            $this->connection[$this->connectionIndex]->onMessage=$this->onMessage($global);
            $this->connection[$this->connectionIndex]->onClose=$this->onClose($global);
            $this->connection[$this->connectionIndex]->onError=$this->onError();

            $this->connect($this->connection[$this->connectionIndex]);
            $this->other($this->connection[$this->connectionIndex],$global);

            $this->connectionIndex++;
        };
    }

    private function onConnect(array $keysecret){
        return function($con) use($keysecret){
            if(empty($keysecret)) return;

            $this->keysecretInit($keysecret,[
                'connection'=>1,
                'auth'=>0,
            ]);

            switch ($this->config['platform']){
                case 'spot':{
                    $data=[
                        "action"=>"req",
                        "ch"=>"auth",
                        'params'=>$this->auth($con->tag_baseurl,$keysecret),
                    ];

                    $con->send(json_encode($data));

                    $this->log($keysecret['key'].' private send auth');
                    $this->log($data);
                    break;
                }
                default:{
                    $data=[
                        "op"=>"auth",
                        "type"=>"api",
                    ];
                    $data=array_merge($data,$this->auth($con->tag_baseurl,$keysecret));

                    $con->send(json_encode($data));

                    $this->log($keysecret['key'].' private send auth');
                    $this->log($data);
                    break;
                }
            }

            $this->log($keysecret['key'].' new connect send');
        };
    }

    private function onMessage($global){
        return function($con,$data) use($global){
            $data=$this->getDecodeData($con->tag,$data);

            //******************************************public
            //public ping
            if(isset($data['ping'])) {
                $con->send(json_encode(['pong'=>$data['ping']]));
                $this->log($con->tag.' send pong '.$data['ping']);
                return;
            }

            //market kline
            if(isset($data['ch']) && $data['ch']!='auth') {
                $table=strtolower($data['ch']);

                //私有数据存入队列
                if(!in_array($con->tag,$this->public_url)) {
                    $table=$this->userKey($con->tag_keysecret,$table);
                    $global->saveQueue($table,$data);
                }else{
                    $global->save($table,$data);
                }

                return;
            }

            //******************************************spot
            //spot order ping
            if(isset($data['action']) && $data['action']=='ping') {
                $temp=$data;
                $temp['action']='pong';
                $con->send(json_encode($temp));
                $this->log($con->tag_keysecret['key'].' send pong '.$temp['data']['ts']);
                return;
            }

            //spot order auth login
            if(isset($data['ch']) && $data['ch']=='auth' && $data['code']=='200') {
                $this->keysecretInit($con->tag_keysecret,[
                    'connection'=>1,
                    'auth'=>1,
                ]);
                $this->log($con->tag_keysecret['key'].' auth login '.json_encode($data));
                return;
            }


            //******************************************dont spot
            //dont spot order ping
            if(isset($data['op']) && $data['op']=='ping') {
                $temp=$data;
                $temp['op']='pong';
                $con->send(json_encode($temp));
                $this->log($con->tag_keysecret['key'].' send pong '.$temp['ts']);
                return;
            }

            //dont spot order auth login
            if(isset($data['op']) && $data['op']=='auth' && isset($data['data']['user-id'])) {
                $this->keysecretInit($con->tag_keysecret,[
                    'connection'=>1,
                    'auth'=>1,
                ]);
                $this->log($con->tag_keysecret['key'].' auth login '.json_encode($data));
                return;
            }

            if(isset($data['topic'])) {
                $table=strtolower($data['topic']);
                if(!in_array($con->tag,$this->public_url)) {
                    $table=$this->userKey($con->tag_keysecret,$table);
                    $global->saveQueue($table,$data);
                }else{
                    $global->save($table,$data);
                }

                return;
            }

            $this->log($data);
        };
    }

    private function onClose($global){
        return function($con) use($global){
            //这里连接失败 会轮询 connect
            if(in_array($con->tag,$this->public_url)) {
                //TODO如果连接失败  应该public  private 都行重新加载
                $this->log($con->tag.' reconnection');

                $this->reconnection($global,'public');

                $con->reConnect(20);
            }else{
                $this->log('connection close '.$con->tag_keysecret['key']);

                Timer::del($con->timer_other);
            }
        };
    }

    private function onError(){
        return function($con, $code, $msg){
            $this->log('onerror code:'.$code.' msg:'.$msg);
        };
    }

    private function connect($con){
        $con->connect();
    }

    private function other($con,$global){
        $time=isset($this->config['listen_time']) ? $this->config['listen_time'] : 2 ;

        $con->timer_other=Timer::add($time, function() use($con,$global) {
            $this->subscribe($con,$global);

            $this->unsubscribe($con,$global);

            $this->order($con,$global);

            $this->debug($con,$global);

            $this->log('listen '.$con->tag);
        });
    }

    /**
     * 调试用
     * @param $con
     * @param $global
     */
    private function debug($con,$global){
        if(in_array($con->tag,$this->public_url)) {
            //public
            $debug=$global->get('debug');

            if(isset($debug['public']) && $debug['public'][$con->tag]=='close'){
                $this->log($con->tag.' debug '.json_encode($debug));

                $debug['public'][$con->tag]='recon';
                $global->save('debug',$debug);

                $con->close();
            }
        }else{
            //private
        }
    }

    private function subscribe($con,$global){
        $sub=$global->get('add_sub');
        if(empty($sub)) {
            //$this->log($con->tag.' subscribe dont change return');
            return;
        }

        $temp=$this->channelType($sub);

        if($con->tag=='market' && !empty($temp['market'])){
            foreach ($temp['market'] as $v){
                $data=[
                    "sub"=>current($v),
                    'id'=>$this->getId()
                ];

                $data=json_encode($data);
                $con->send($data);

                $this->log($data);
                $this->log($con->tag.' subscribe send');
            }

            $global->addSubUpdate($temp['market']);
            $global->allSubUpdate($temp['market'],'add');
        }

        if($con->tag=='kline' && !empty($temp['kline'])){
            foreach ($temp['kline'] as $v){
                $data=[
                    "sub"=>current($v),
                    'id'=>$this->getId()
                ];

                $data=json_encode($data);
                $con->send($data);

                $this->log($data);
                $this->log($con->tag.' subscribe send');
            }

            $global->addSubUpdate($temp['kline']);
            $global->allSubUpdate($temp['kline'],'add');
        }

        if($con->tag!='market' && !empty($temp['private'])){
            //判断是否鉴权登录
            $keysecret=$global->get('keysecret');

            $temp_sub=[];
            foreach ($temp['private'] as $v){
                if($keysecret[$v[1]['key']]['auth']==0) continue;

                if($this->getPlatform()=='spot'){
                    $data=[
                        "action"=>'sub',
                        'ch'=>current($v)
                    ];
                }else{
                    $data=[
                        "op"=>'sub',
                        'topic'=>current($v)
                    ];
                }

                $data=json_encode($data);
                $con->send($data);

                $this->log($data);
                $this->log($con->tag_keysecret['key'].' subscribe send');

                $temp_sub[]=$v;
            }

            if(!empty($temp_sub)){
                $global->addSubUpdate($temp_sub);
                $global->allSubUpdate($temp_sub,'add');
            }
        }
        return;
    }

    private function unsubscribe($con,$global){
        $unsub=$this->get('del_sub');
        if(empty($unsub)) {
            //$this->log($con->tag.' unsubscribe dont change return');
            return;
        }

        $temp=$this->channelType($unsub);

        if($con->tag=='market' && !empty($temp['market'])){
            foreach ($temp['market'] as $v){
                $data=[
                    "unsub"=>current($v),
                    'id'=>$this->getId()
                ];

                $data=json_encode($data);
                $con->send($data);

                $this->log($data);
                $this->log($con->tag.' unsubscribe send');
            }

            $global->delSubUpdate($temp['market']);
            $global->allSubUpdate($temp['market'],'del');
        }

        if($con->tag=='kline' && !empty($temp['kline'])){
            foreach ($temp['kline'] as $v){
                $data=[
                    "unsub"=>current($v),
                    'id'=>$this->getId()
                ];

                $data=json_encode($data);
                $con->send($data);

                $this->log($data);
                $this->log($con->tag.' unsubscribe send');
            }

            $global->delSubUpdate($temp['kline']);
            $global->allSubUpdate($temp['kline'],'del');
        }

        if($con->tag!='market' && !empty($temp['private'])){
            $temp_sub=[];
            foreach ($temp['private'] as $v){
                if($this->getPlatform()=='spot'){
                    $data=[
                        "action"=>'unsub',
                        'ch'=>current($v)
                    ];
                }else{
                    $data=[
                        "op"=>'unsub',
                        'topic'=>current($v)
                    ];
                }

                $data=json_encode($data);
                $con->send($data);

                $this->log($data);
                $this->log($con->tag_keysecret['key'].' unsubscribe send');

                $temp_sub[]=$v;
            }

            if(!empty($temp_sub)){
                $global->delSubUpdate($temp_sub);
                $global->allSubUpdate($temp_sub,'del');
            }
        }

        return;
    }

    private function order($con,$global){
        $keysecret=$global->get('keysecret');
        if(empty($keysecret)) return;

        foreach ($keysecret as $k=>$v){
            //是否取消连接
            if($con->tag!='market' && isset($v['connection_close']) && $v['connection_close']==1){
                $con->close();

                $this->keysecretInit($v,[]);

                $this->log('private connection close '.$v['key']);
                continue;
            }


            //是否有新的连接
            if(isset($v['connection'])){
                switch ($v['connection']){
                    case 0:{
                        $this->keysecretInit($v,[
                            'connection'=>2,
                            'connection_close'=>0,
                            'auth'=>0,
                        ]);

                        $this->log('private order new connection '.$v['key']);

                        $this->addConnection($v['key'],$v);
                        break;
                    }
                    case 1:{
                        //$this->log('login');
                        break;
                    }
                    case 2:{
                        $this->log('private already order return '.$v['key']);
                        break;
                    }
                }
            }

        }
    }


}
