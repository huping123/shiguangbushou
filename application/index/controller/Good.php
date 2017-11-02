<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Session;
use app\index\model\User;
use app\index\model\Goods;
use app\index\model\Category;
use app\index\model\Picture;
use app\index\model\Shopcar;
use think\Request;

class Good extends Controller
{
  protected $goods;
	protected $picture;
	public function _initialize()
    {
        $this ->user = new User(); 
        $this->goods = new Goods();
        $this->shopcar = new Shopcar();
        $this->picture = new Picture();
        $this->category = new Category();
    }



 public function Product()
    {
      //获取具体商品的id
      $id = $this->request->param('pid');
      
        //id传到goods表里查询详情
       $info = $this->goods->res($id);
       //dump($info);
       //id传到picture表里查询详情
       $result = $this->picture->res1($id);
      // //picture表里的信息
      foreach ($result as $key => $value1) {
          $frontview = $value1['frontview'];
          $left1 = $value1['leftone'];
          $left2 = $value1['lefttwo'];
          $right1 = $value1['rightone'];
          $right2 = $value1['righttwo'];
       }
       //goods表里的信息
        foreach ($info as $key => $value) {
          $title = $value['name'];
          $price = $value['price'];
          $url = $value['url'];
        }

        //查询评论的内容
      //   $info1 = $this->comment->comm($id);
         //获取商品的颜色
         $color = $this->goods->cor($id);
        //  dump($color);
      //   //获取商品的规格
         $size = $this->goods->siz($id);
        // dump($size);
      //   //查询个人购物车里的东西
        if (!empty(Session::get('mobile'))){
            //用户名
            $una = Session::get('mobile');
            //查询用户的id
              $gid = $this->user->gouwu($una); 
            //根据用户id去查询购物车
            $gouwu = $this->shopcar->two($gid); 
            // var_dump($gouwu);
            //购物车总价格
            $arr = [];
            foreach ($gouwu as $key => $vue) {
                $pice1 = $vue['money'];
                $n =  $vue['nums'];
                $arr[] = $pice1 * $n;
            }
            $sum = (array_sum($arr)); 
            $this->assign('gouwu',$gouwu);
            $this->assign('sum',$sum);
            }
      //     //一级分类
          $result = $this->category->lis();
      //    //用户同款类型喜欢推荐
      //    $ku = $this->goods->kun($id);
          $nums = 1;
      //    $this->assign('ku',$ku);
          $this->assign('result',$result);
          $this->assign('nums',$nums);
      //    $this->assign('id',$id);
          $this->assign('color',$color);
          $this->assign('size',$size);
      //    $this->assign('info1',$info1);
      //    $this->assign('bigpic3',$bigpic3);
      //    $this->assign('bigpic2',$bigpic2);
      //    $this->assign('bigpic1',$bigpic1);
         $this->assign('left1',$left1);
         $this->assign('left2',$left2);
         $this->assign('right1',$right1);
         $this->assign('right2',$right2);
         $this->assign('frontview', $frontview);
         $this->assign('price',$price);
         $this->assign('info',$info);
          $this->assign('title',$title);
         //$name = Session::get('username');
         //$this->assign('name',$name);
         $this->assign('url',$url);
         $this->assign('id',$id);
         return  $this->fetch();
     }

    public function ue()
    {   
          if (!empty(Session::get('mobile'))){
            //商品名称
             $ttie = input('post.title');
             dump($ttie);
            //根据商品的名称去查商品的id
            $ming = $this->goods->ming($ttie);
           // dump($ming);
            //商品价格
             $pee = input('post.pee');
            //  //商品颜色
              $colorr = input('post.colorr');
              dump($colorr);
            //  //商品数量
              $nums = input('post.nums');
            //  dump($nums);
            //  //商品的规格
            //   $sizee = input('post.sizee');
            //用户名
            $uname1 = Session::get('mobile');
             //根据商品名去查商品的id
             $id = $this->goods->gid($ttie);
            //查询用户的id
              $uid = $this->user->uid($uname1);
            //插入数据
            $arr = [
              'spid' => $uid,
              'ptitle' =>$ttie,
              'nums' =>$nums,
               'wid' => $ming,
              'money'  => $pee,
              'pcolor' => $colorr,
            //  'psize' => $sizee,
              'rgetime' => time()
            ];
             $result2 = $this->shopcar->one($arr);
              if ($result2) {
               $this->success('添加购物车成功','/index/index/index');
             } else {
              $this->success('添加购物车失败','/index/index/index');
             }

          } else {
               $this->success('请登录之后在添加商品','/index/index/index');
          }
    }
    //收藏商品
    // public function collect()
    // {
    //    if (!empty(Session::get('mobile'))){
    //       $mobile = Session::get('mobile');
    //       //根据用户名去查询用户的id
    //       $us = $this->user->usd($mobile);
    //       //用户id
    //       $uid = $us[0]['u_id'];
    //      //获取商品的id
    //      $aid = ($_POST['aid']);
    //      $shouchang = $this->goods->shou($aid);
    //      foreach ($shouchang as $key => $value) {
    //        //商品的id 
    //         $sid = $value['pid'];
    //        //商品的名字
    //        $uname = $value['uname'];
    //        //商品的价格
    //        $pice = $value['pice']; 
    //      }
    //      //插入收藏表
    //       $data1 = [
    //               'cname' => $uname,
    //               'cpice' => $pice,
    //               'eid'  => $sid,
    //               'oid' => $uid
    //             ];
    //     $result3 = $this->collect->cang($data1);
    //      if ($result3) {
    //         $this->success('收藏商品成功','/index/index/index');
    //      } else {
    //          $this->success('收藏商品失败','/index/index/index');
    //      }

    //        } else {
    //            $this->success('请登录之后在收藏商品','/index/index/index');
    //        }
    //  }
}