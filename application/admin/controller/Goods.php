<?php
namespace app\admin\Controller;
use app\admin\controller\Auser;
use app\admin\model\Category;
use think\Db;
use think\Controller;
use think\Request;
class Goods extends  Auser
{   
     protected $category; 
	 protected $is_login = ['*'];
	  public function _initialize()
	 {
      $this->category = new Category;
	
	 }
	public function product_category()
	{
		return $this->fetch();
	}
	   public function product_category_add()
    { 
    
    	$data =$this->category->field('*,concat(path,',',id)')->order('path')->select();
        
    		foreach($data as $k=>$v){
			$data[$k]['name'] =str_repeat("|---",$v['level']).$v['name'];
		}

    	$this->assign('data',$data);
    	return $this->fetch();
    }
    public function categoryadd()
	{
		//无限级分类添加分类
		$data['name']=$_POST['name'];
		$data['pid']=$_POST['pid'];
		if ($data['name'] !="" && $data['pid'] != 0) {
			$path=$this->category->field("path")->find($data['pid']);
			$data['path']=$path['path'];
			$data['level']=substr_count($data['path'],",");

			$re=$this->category->save($data);
			$path['id']=$re;
			$path['path']=$data['path'].','.$re;
			$path['level']=substr_count($path['path'],",");
			$res=$this->category->save(['path'=>$path['path'],'level'=>$path['level']]);
			//var_dump($res);
			if ($res) {

				echo '<script>alert("添加成功");parent.location.href=" product_category"</script>';
			}else{
				echo '<script>alert("添加失败");parent.location.href=" product_category"</script>';
			}
			}else if($data['name']!="" && $data['pid'] ==0){
			//$path=$this->category->field("path")->find($data['pid']);
			$data['path']=$data['pid'];
			$data['level']=1;
            $re=$this->category->save($data);

			$path['id']=$re;
			$path['path']=$data['path'].','.$re;
			$res=$this->category->save(['path'=>$path['path'],'level'=>$data['level']]);
			//var_dump($res);
			if ($res) {

				echo '<script>alert("添加成功");parent.location.href=" product_category"</script>';
			}else{
				echo '<script>alert("添加失败");parent.location.href=" product_category"</script>';
			}
		}else{

			
				echo '<script>alert("添加失败，内容不能为空");parent.location.href=" product_category"</script>';

		}	


		
	}

}