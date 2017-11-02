<?php
namespace app\index\model;
use think\Model;
use think\Db;
use think\Session;
use app\index\model\Goods;
class Category extends Model
{
public function lis()
	{
		//一级分类名称
	return Db::name('category')->where('cpid= 0')->select();		
		
	}
	public function liss()
	{	//二级分类名称
		return Db::name('category')->where('cpid!= 0')->select();
		 
	}
	public function cha()
	{
		//三级分类名称
		return Db::name('category')->select();		
		 
	}
	//遍历商品列表
	public function bin($id)
	{
		return  Db::field('goods.price,goods.name,goods.pid,goods.url')
		->table(['wbby_category'=>'category','wbby_goods'=>'goods'])
		->where("category.cid = goods.parid")
		->where("category.cpid = $id")
		->select();
	}
}