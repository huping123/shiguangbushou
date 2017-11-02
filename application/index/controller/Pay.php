<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use app\index\model\Pay as PayModel;
use app\index\model\Category;
use app\index\model\User;
use app\index\model\Order;
use app\index\model\Shouhuo;
use app\index\model\Shopcar;
class Pay extends Controller
  {       
      protected $category;
      protected $user;
      protected $pay;
      //protected $order;
    //  protected $shouhuo;
      protected $shoppingcar;
      public function _initialize()
    {
        $this ->pay = new PayModel();
        $this ->category = new Category();
      //  $this ->order = new Order();
        $this ->user = new User();
        //$this ->shouhuo = new Shouhuo();
        $this ->shopcar = new Shopcar();
    }
	 public function pay()
    {
        $mobile = Session::get('mobile');
        //查看购物车
         $jcc = $this->shopcar->che($mobile); 
         dump($jcc);
        $arr = [];
        foreach ($jcc as $key => $value) {
               $num = $value['nums'];
               $price = $value['money'];
               $arr[] = $price * $num;
        }
        //删除购物车中商品
        if (!empty($_POST['sid'])) {
            //获取要删除的商品id
           $id = $_POST['sid'];
           $sid  = $this->shopcar->san($id);
           if ($sid) {
                $this->success('删除成功','/index/pay/pay');
           } else{
                $this->success('删除失败','/index/pay/pay');
           }
        }
         $he = (array_sum($arr));
        //   //一级分类
          $result = $this->category->lis();

          $this->assign('result',$result);
         $this->assign('he',$he);
        $this->assign('mobile',$mobile);
         $this->assign('jcc',$jcc);
         return  $this->fetch();
     }
      public function payone()
    {
         $name = Session::get('mobile');
        //查看购物车
        $jcc = $this->shopcar->che($name); 
        dump($jcc);
        if (empty($jcc)) {
             $this->success('请添加商品在下单','/index/index/index');
        }
        $arr1 = [];
        foreach ($jcc as $key => $value) {
               $num1 = $value['nums'];
               $pice1 = $value['money'];
               $arr1[] = $pice1 * $num1;
        }
        // //商品的总价格
         $sum1 = (array_sum($arr1));
        //  //收货订单详情
         $in =$this->user->shou($name);
         $this->assign('in',$in);
          $this->assign('sum1',$sum1);
         $this->assign('jcc',$jcc);
        //  $this->assign('name',$name);
        //  //一级分类
          $result = $this->category->lis();
         
          $this->assign('result',$result);
         return  $this->fetch();
     }
    //   public function paytwo()
    // {
    //      $name = Session::get('username');
    //      $this->assign('name',$name);
    //      $zi = $this->order->xin($name);
    //      $ar =$zi[0];
    //      $omoney = $ar['o_money'];
    //      $ordhao = $ar['ord_hao'];
    //      $kuidi = $ar['kuaidi'];
    //      $ka = $ar['ka'];
    //      $this->assign('ka',$ka);
    //      $this->assign('kuidi',$kuidi);
    //      $this->assign('ordhao',$ordhao);
    //      $this->assign('money',$omoney);
    //      //一级分类
    //      $result = $this->shop->lis();
         
    //      $this->assign('result',$result);
    //      return  $this->fetch();
    //  }
     //生成订单
     public function order()
     {
       if(!empty(Session::get('monile'))){
            $monile = Session::get('monile');
             if (empty($_POST['chose'])) {
              $this->success('请选择要购买的宝贝','/index/pay/payone');
            }
            $arr = $_POST['chose'];
            dump(88);
            // if (empty($_POST['nuname']) & empty($_POST['nuemail']) & empty($_POST['nuphone'])) {
            //    $this->success('请到个人中心完善收货信息在下单','/index/myself/Member_Address');
            // }
            // //接受支付方式
            // $ka = ($_POST['ka']);
            // if ($ka == 3) {
            //      $ka = '余额支付';
            // } elseif ($ka == 4){
            //      $ka = '货到付款';
            // } else {
            //     $ka = '支付宝';
            // }

            // //接受默认快递
            // $kuaidi = ($_POST['you']);
            // if ($kuaidi == 1) {
            //      $kuaidi = '申通快递';
            // } else {
            //      $kuaidi = '中通快递';
            // }
            // $zhi =  $this->shopcar->chu($arr);
            // foreach ($zhi as $key => $value) {
            //  $arr1[] =  $value['ptitle'];
            //  $arr2[] =  $value['pcolor'];
            //  $arr3[] = $value['psize'];
            //  $arr4[] = $value['id'];
            //  $mon = $value['money'];
            // }
            //  $biaoti = implode('+', $arr1);
            //  $yanse = implode('+', $arr2);
            //  $cicun= implode('+', $arr3);
            //  $cid= implode('+', $arr4);
            // //生成订单编号
            // if($zhi){
            //     $first = mt_rand(10000,99999);
            //     $time  = time();
            //     $ordernum = '010' . $first . $time;
            // //查询用户的id
            // $xin = $this->user->us($username);
            // $yid = $xin[0]['u_id'];
            // $time = date('Y-m-d H:i:s',time());
            // $ordinfo = '商品名称:' .  $biaoti. '订单总价：' . $mon. '下单时间：' . $time;
            // //生成订单
            //  $data = [  
            //         'o_id'        =>$yid,
            //         'ss_id'        => $cid,
            //         'ss_name'      => $biaoti,
            //         'color'      => $yanse,
            //         'size'      => $cicun,
            //         'ord_hao'      => $ordernum,
            //         'create_time'      => $time,
            //         'statu'     => 2,
            //         'info' => $ordinfo,
            //         'kuaidi'=>$kuaidi,
            //         'ka' => $ka,
            //         'o_money'     => $mon
            //     ];

            //   //插入数据
            //   $in = $this->order->se($data);
            //   //收货表生成信息
            //   //查询用户的id
            //   $ui = $this->user->sd($username);
            //   $uid = $ui[0]['u_id'];
            //   // var_dump($_POST);die;
            //   $numane = $_POST['nuname'];
            //   $nuemail = $_POST['nuemail'];
            //   $nuinfomation = $_POST['nuinfomation'];
            //   $nuphone = $_POST['nuphone'];
            //   $nuyoubian = $_POST['nuyoubian'];
            //   $data1 = [
            //     'sname' =>  $numane,
            //     'sphone' => $nuphone,
            //     'semail' => $nuemail,
            //     'infomation'=> $nuinfomation,
            //     'sta'     => 1,
            //      'yyid' =>  $uid,
            //      'youbian' =>  $nuyoubian,
            //      'dingdanbianhao' => $ordernum
            //   ];
            //    $huo = $this->shouhuo->sh($data1);
            //   if ($in) {
            //     $this->success('订单生成成功','/index/pay/paytwo');
            //   } else {
            //     $this->success('订单生成失败','/index/pay/pay');
            //   }

            //   }
       }
     }
}