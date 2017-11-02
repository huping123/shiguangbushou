<?php
namespace app\admin\Controller;
use app\admin\controller\Auser;
use app\admin\model\Category;
use app\admin\model\Goods;
use think\Db;
use think\Controller;
use think\Request;
use think\Validate;
class Goods extends  Auser
{    //protected $goods; 
     protected $category; 
	 protected $is_login = ['*'];
	  public function _initialize()
	 {
	 // $this->goods = new Goods;	
      $this->category = new Category;
	  
	 }
	public function product_category()
	{
		return $this->fetch();
	}
	  //获取分类数据
    public function product_category_ajax()
    {   
    	$data = $this->category->field('cid,cpid,name')->select();
    	echo json_encode($data);
    }
    //删除分类信息
    public function product_category_del()
    {   
    	
    	 $cid=$_GET['cid'];

     //    //var_dump($cid);
    	 $data=$this->category->where('cpid='.$cid.'')->find();
    	// var_dump($data);
    	if($data){
    		
    	 	 $str="菜单下面还有子菜单，不能删除";
    	 	 echo json_encode($str);
    	 }else{
    	 	 
    	 	$re=$this->category->where('cpid!='.$cid.'')->delete($cid);

    	 	 if($re){
    	 	 	echo 1;
    	 	 }
    	 } 
    }	
	   public function product_category_add()
    { 
        
    	$data =$this->category->field('*,concat(path,',',cid)')->order('path')->select();
        
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
		$data['cpid']=$_POST['cpid'];
		if ($data['name'] !="" && $data['cpid'] != 0) {
			$path=$this->category->field("path")->find($data['cpid']);
			$data['path']=$path['path'];
			$data['level']=substr_count($data['path'],",");

			$re=$this->category->save($data);
			$path['cid']=$re;
			$path['path']=$data['path'].','.$re;
			$path['level']=substr_count($path['path'],",");
			$res=$this->category->save(['path'=>$path['path'],'level'=>$path['level']]);
			//var_dump($res);
			if ($res) {

				echo '<script>alert("添加成功");parent.location.href=" product_category"</script>';
			}else{
				echo '<script>alert("添加失败");parent.location.href=" product_category"</script>';
			}
			}else if($data['name']!="" && $data['cpid'] ==0){
			//$path=$this->category->field("path")->find($data['pid']);
			$data['path']=$data['cpid'];
			$data['level']=1;
            $re=$this->category->save($data);

			$path['cid']=$re;
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
	//商品管理
	public function product_list()
	{   
		$Goods = new Goods;
		$list =Db::name('Goods')->where('isdel',0)->paginate(5);
        $page = $list->render();
		$this->assign('list',$list);
		$this->assign('page',$page);
		return $this->fetch();
	}
	//添加商品详情
	public function product_add()
	{   
		$data =$this->category->field('*,concat(path,',',cid)')->order('path')->select();
        
    		foreach($data as $k=>$v){
			$data[$k]['name'] =str_repeat("|---",$v['level']).$v['name'];
		}

    	$this->assign('data',$data);
		return $this->fetch();
	}
	//图片上传
	public function upload(Goods $de)
	{   
		$files = request()->file('image');
		$arr = [];
		 foreach ($files as $file) {
		 	$info = $file->validate(['size'=>15678000,'ext'=>'jpg,gif,png'])->move(ROOT_PATH . 'public' . DS . 'uploads');
		 	 if ($info) {
	  	 	//长传成功，获取上传信息
		 	 	$arr[] = str_replace('\\','/',$info->getSaveName());
		 	 }else{
		 	 	echo $file->getError();
		 	 }

	  }
		  $pictures = implode(',',$arr);
		 $re = $de ->anything($pictures);
		  var_dump($re);
        if(!empty($re))
		 {
			$this->success('添加成功',url('admin/goods/product_list'));
	 }else{
			$this->error('加入失败',url('admin/goods/product_add'));
		}
	}
	//商品详情修改
	public function product_change()
	{  $gid = $_GET['gid'];
	   $re = Db::name('goods')->where('gid',$gid)->find();
	  var_dump($re);
	 //  $arr = explode(',',$re['pictures']);
	  // var_dump($arr);
       $data =$this->category->field('*,concat(path,',',cid)')->order('path')->select();
        
    		foreach($data as $k=>$v){
			$data[$k]['name'] =str_repeat("|---",$v['level']).$v['name'];
		}

    	$this->assign('data',$data);
		//$this->assign('arr',$arr);
	    $this->assign('gid',$gid);
	    $this->assign('re',$re);
        
		return $this->fetch();
	}
	public function change(Goods $de)
	{
		$files = request()->file('image');
		$arr = [];
		 foreach ($files as $file) {
		 	$info = $file->validate(['size'=>15678000,'ext'=>'jpg,gif,png'])->move(ROOT_PATH . 'public' . DS . 'uploads');
		 	 if ($info) {
	  	 	//长传成功，获取上传信息
		 	 	$arr[] = str_replace('\\','/',$info->getSaveName());
		 	 }else{
		 	 	echo $file->getError();
		 	 }

	  }
		  $pictures = implode(',',$arr);
		 $re = $de ->xiugai($pictures);
		  //var_dump($re);
        if(!empty($re))
		 {
			$this->success('添加成功',url('admin/goods/product_list'));
	 }else{
			$this->error('加入失败',url('admin/goods/product_change'));
		}
	}
	public function del(Request $request)
	{
		$gid = $request->param('gid');
		$re = Db::name('goods')->where('gid',$gid)->setField('isdel',1);
		//var_dump($re);
		$info = Db::name('goods')->where('isdel',0)->count();
	 	if ($re) {
	 		return json(['errcode'=>1,'info'=>$info]);
	 	}else{
			return json(['errcode'=>0,'info'=>$info]);
		}
	 }
}