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

    private $market_url;
    private $order_url;

    function __construct(array $config=[])
    {
        $this->config=$config;
    }

    public function start(){
        $this->worker = new Worker();
        $this->server();

        $this->worker->onWorkerStart = function() {
            $this->addConnection('public');
        };

        Worker::runAll();
    }

    private function addConnection(string $tag,array $keysecret=[]){
        $this->newConnection()($tag,$keysecret);
    }

    private function getBaseUrl($global,$keysecret){
        if(is_array($this->config['platform'])){
            if(empty($keysecret)) return $this->config['platform']['market'];

            return $this->config['platform']['order'];
        }

        switch ($this->config['platform']){
            case 'option':{
                if(empty($keysecret)) return $this->market_url='ws://api.hbdm.com/option-ws';
                return $this->order_url='ws://api.hbdm.com/option-notification';
            }
            case 'linear':{
                if(empty($keysecret)) return $this->market_url='ws://api.hbdm.com/linear-swap-ws';
                return $this->order_url='ws://api.hbdm.com/linear-swap-notification';
            }
            case 'swap':{
                if(empty($keysecret)) return $this->market_url='ws://api.hbdm.com/swap-ws';
                return $this->order_url='ws://api.hbdm.com/swap-notification';
            }
            case 'future':{
                if(empty($keysecret)) return $this->market_url='ws://api.hbdm.com/ws';
                return $this->order_url='ws://api.hbdm.com/notification';
            }
            default:{//spot
                if(empty($keysecret)) return $this->market_url='ws://api.huobi.pro/ws';
                return $this->order_url='ws://api.huobi.pro/ws/v2';
            }
        }
    }

    private function newConnection(){
        return function($tag,$keysecret){
            $global=$this->client();

            $baseurl=$this->getBaseUrl($global,$keysecret);

            $this->connection[$this->connectionIndex] = new AsyncTcpConnection($baseurl);
            $this->connection[$this->connectionIndex]->transport = 'ssl';

            //自定义属性
            $this->connection[$this->connectionIndex]->tag=$tag;//标记公共连接还是私有连接
            if(!empty($keysecret)) $this->connection[$this->connectionIndex]->tag_keysecret=$keysecret;//标记私有连接

            $this->connection[$this->connectionIndex]->onConnect=$this->onConnect($keysecret);
            $this->connection[$this->connectionIndex]->onMessage=$this->onMessage($global);
            $this->connection[$this->connectionIndex]->onClose=$this->onClose();
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
                        'params'=>$this->auth($this->order_url,$keysecret),
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
                    $data=array_merge($data,$this->auth($this->order_url,$keysecret));

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

            //pulibc market
            if(isset($data['ch']) && $data['ch']!='auth') {
                $table=strtolower($data['ch']);
                $global->save($table,$data);
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
            if(isset($data['ch']) && $data['ch']!='auth' && $data['code']=='200') {
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
                if($con->tag != 'public') $table=$this->userKey($con->tag_keysecret,$table);
                $global->save($table,$data);
                return;
            }

            $this->log($data);
        };
    }

    private function onClose(){
        return function($con){
            //这里连接失败 会轮询 connect
            if($con->tag=='public') {
                //TODO如果连接失败  应该public  private 都行重新加载
                $this->log('reconnection');
                $con->reConnect(5);
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

            $this->log('listen '.$con->tag);
        });
    }

    /*private function request(){

    }*/

    private function subscribe($con,$global){
        $sub=$global->get('add_sub');
        if(empty($sub)) {
            //$this->log($con->tag.' subscribe dont change return');
            return;
        }

        //是否有私有订阅
        $temp=['public'=>[],'private'=>[]];
        foreach ($sub as $k=>$v){
            if(count($v)>1) array_push($temp['private'],$v);
            else array_push($temp['public'],$v);
        }

        if($con->tag=='public' && !empty($temp['public'])){
            foreach ($temp['public'] as $v){
                $data=[
                    "sub"=>current($v),
                    'id'=>$this->getId()
                ];

                $data=json_encode($data);
                $con->send($data);

                $this->log($data);
                $this->log('public subscribe send');
            }

            $global->addSubUpdate($temp['public']);
            $global->allSubUpdate($temp['public'],'add');
        }

        if($con->tag!='public' && !empty($temp['private'])){
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

        //是否有私有订阅
        $temp=['public'=>[],'private'=>[]];
        foreach ($unsub as $k=>$v){
            if(count($v)>1) array_push($temp['private'],$v);
            else array_push($temp['public'],$v);
        }

        if($con->tag=='public' && !empty($temp['public'])){
            foreach ($temp['public'] as $v){
                $data=[
                    "unsub"=>current($v),
                    'id'=>$this->getId()
                ];

                $data=json_encode($data);
                $con->send($data);

                $this->log($data);
                $this->log('public unsubscribe send');
            }

            //*******订阅成功后，删除del_sub  public 值
            $global->delSubUpdate($temp['public']);

            //*******订阅成功后 更改 all_sub  public 值
            $global->allSubUpdate($temp['public'],'del');
        }

        if($con->tag!='public' && !empty($temp['private'])){
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
            if($con->tag!='public' && isset($v['connection_close']) && $v['connection_close']==1){
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
