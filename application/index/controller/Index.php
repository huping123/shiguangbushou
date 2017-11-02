<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Session;
use think\Validate; //验证码
use app\index\model\Goods;
use app\index\model\Category;
class Index extends controller
{
  protected $goods;
	protected $category;
	public function _initialize()
    {

        $this->goods = new Goods();
        $this->category = new Category();
    }

    public function index(Request $request) {
      $mobile = Session::get('mobile');
      
      //一级分类
      $result = $this->category->lis();
      //二级分类
      $two= $this->category->liss(); 
        //三级分类
      $three = $this->category->cha();
      $apple = $this->goods->one();

        //首页轮播图
      $lun =$this->goods->lun(); 
// dump($apple);
      $this->assign('result',$result);
      $this->assign('two',$two);
      $this->assign('three',$three);
      $this->assign('apple',$apple);
      $this->assign('lun',$lun);
      $this->assign('mobile',$mobile);
      
      return $this->fetch();




















    	// $phone = $this->goods->one();
    	// //dump($phone);
    	//     $this->assign('phone',$phone);
     //  $list = $this->category->smallList();
     //   dump($list);
    // public function xinx()
    // {
      // dump(time());
        // $xinx=$this->goods->with('goodsGallery')->find('2')->toArray();//查询一条ID为15的用户数据；toArray()是将结果转为数组。
      //    $xinx=$this->goods::get(2);
      //    $tt = $xinx->goodsMemory;

      //    dump($xinx);
    	 // // dump($this->assign('tt',$tt));

      //    // dump($xinx);
      //     dump($tt);
    // }





















    	return $this->fetch();
    }
}
