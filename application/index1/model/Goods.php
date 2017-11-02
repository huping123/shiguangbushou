<?php
namespace app\index\model;

use think\Model;
use think\Db;
use think\Session;
class Goods extends Model
{
	//手机专区
	public function one()
	 {
	 	return Db::name('goods')->where('parid',1)->limit(1,8)->select();
	 	 
	 }

	// //获取传过来的id获取单个商品颜色
	//   public function cor($id)
	//   {
	//   	return Db::name('color')->where("r_id = $id")->select();
	//   }
 // //获取传过来的id获取单个商品信息
	//   public function res($id)
	//   {
	//   	return Db::name('goods')->where("pid = $id")->select();
	//   }
	//   //获取传过来的id获取单个商品颜色
	//   public function cor($id)
	//   {
	//   	return Db::name('color')->where("r_id = $id")->select();
	//   }
	//    //获取传过来的id获取单个商品规格
	//   public function siz($id)
	//   {
	//   	return Db::name('size')->where("s_id = $id")->select();
	//   }
	//   //根据商品名称查询商品的id
	//   public function gid($ttie)
	//   {	
	//   	// var_dump($ttie);
	//   	 $ttie = Db::name('goods')->where("uname", $ttie)->select();
	//   	 return $ttie = $ttie[0]['pid'];
	//   }
	//   //查询商品的id
	//   public function ming($ttie)
	//   {
	//   	 $ming = Db::name('goods')->where("uname", $ttie)->select();
	//   	 return $ming = $ming[0]['pid'];
	//   }
	//   //查询收藏宝贝的详细信息
	//   public function shou($aid)
	//   {
	//   	return  Db::name('goods')->where("pid", $aid)->select();
	//   }
	//   //模糊搜索
	//   public function neirong($text)
	//   {
	//   	return Db::name('goods')->where('uname','like',"%$text%")->select();
	
	//   }
	  //查询首页轮播图
	  public function lun()
	  {
	  	return	Db::field('lun.images,goods.pid')
			->table(['wbby_lun'=>'lun','wbby_goods'=>'goods'])
			->where("lun.mid = goods.pid")
			->select();

	  }
}