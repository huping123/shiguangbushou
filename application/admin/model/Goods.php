<?php
namespace app\admin\Model;
use think\Model;
use think\Db;

class Goods extends Model
{
	public function GoodsInfo($id)
	 {
	 	return Db::name('goods')->where('gid',$id)->find();
	 }
	
	public function anything($photo)
	{    
	    $goods = new Goods; 
       	$data['name']=$_POST['name'];	
		$cid=explode(",",$_POST['cid']);
        
        $data['cid']=$cid[0];
        $data['cpid']=$cid[1];
		$data['number']=$_POST['number'];
	   	$data['rank']=$_POST['rank'];
		$data['color']=$_POST['color'];
		$data['rom']=$_POST['rom'];
		$data['price']=$_POST['price'];
		$data['stock']=$_POST['stock'];
		$data['address']=$_POST['address'];
		$data['description']=$_POST['editorValue'];
        $data['pictures']=$photo;
	//]);	
      return $goods->save($data);
    }
  
	 public function xiugai($photo)
	 {
	 	$goods = new Goods; 
       	$data['name']=$_POST['name'];	
		$cid=explode(",",$_POST['cid']);
        
        $data['cid']=$cid[0];
        $data['cpid']=$cid[1];
		$data['number']=$_POST['number'];
	   	$data['rank']=$_POST['rank'];
		$data['color']=$_POST['color'];
		$data['rom']=$_POST['rom'];
		$data['price']=$_POST['price'];
		$data['stock']=$_POST['stock'];
		$data['address']=$_POST['address'];
		$data['description']=$_POST['editorValue'];
        $data['pictures']=$photo;
        $data['gid']=$_POST['hidden'];

        return $goods->update($data);
	 }


}