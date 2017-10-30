<?php
namespace app\admin\Controller;
use app\admin\controller\Auser;
use app\admin\model\Auser as ModelAuser;
use app\admin\model\Role;
use app\admin\model\Per;
use think\Controller;
use think\Validate;
use think\Db;
use think\Request; 
class Adminer extends Auser
{   protected $role;
	protected $per;
	protected $is_login = ['*'];
    public function _initialize()
	{
      $this->role = new Role;
	  $this->per  = new Per;
	  $this->auser = new ModelAuser;
	}
	//权限管理	
	public function admin_Competence(Request $request)
	{   
        $re = $this->per->paginate(3);
        $pid = $request->param('pid');
       // dump($pid);
     	$res = Db::name('per')->where('pid',$pid)->delete();
		//dump($res);
		if($res){
		return $this->success('删除成功');
		}else{
		return $this->error('删除失败');
		}
    
	    $page = $re->render();
	     $this->assign('res',$res);
        $this->assign('page',$page);
        $this->assign('re',$re);
		return $this->fetch();
}
 
//角色管理
	public function admin_Reflection()
	{  
		
		$info = $this->role->paginate(3);
		$page = $info->render();
		$this->assign('page',$page);
		$this->assign('info',$info);
		foreach ($info as $key => $value) {
			$id = $value->rid;
			$list = $this->role->get($id);
			$list->per;
			$role = $list->toArray();
			$per = $role['per'];
			$arr[] = $per;
		}		
		$this->assign('arr',$arr);
		$count = $this->role->count();
		$this->assign('count',$count);
		return $this->fetch();
	}
	public function modify()
	{    
		$data  = $this->request->param();
		//dump($data);
		$info = $this->role->get($data['id']);
		//dump($info);
		$name = $info->name;
		//dump($name);
        $this->assign('rid',$data['id']);
        $this->assign('name',$name);
        foreach ($info->per as $v) {
           
        	$pid = $v->pid;
        	 //dump($v->pid);

        	$arr[] = $pid;
        	//dump($pid); 
        	//dump($id);
        }
        $list = $this->per->select();
       // dump($list);
		$this->assign('arr', $arr);
		$this->assign('list', $list);
		return $this->fetch();
	}
	//给角色添加角色
	public function rolePer()
	{
		$info = $this->request->param();
		$pid = $info['choose'];
		$list = $this->role->get($info['rid']);
		$list->per()->save($pid);
		$this->redirect('admin_Reflection');
	}
	//管理员列表
	public function administrator()
	{   

		$info = $this->auser->paginate(5);
		$str = $this->role->select();	
		$page = $info->render();
		$this->assign('info',$info);
		$this->assign('str', $str);
		$this->assign('page',$page);
		foreach ($info as $key => $value) {
            $uid = $value->uid;
			//dump($uid);
			$list = $this->auser->get($uid);
			$list->role;
			$auser = $list->toArray();
			$role = $auser['role'];
			$arr[] = $role;
		}		
		$this->assign('arr',$arr);
		return $this->fetch();
		
	}
	//对管理员停用或启用
	public function isClose()
	{
		$info = $this->request->param();
		$data = $this->auser->get($info['id']);
		if ($data->is_close) {
			$data->is_close = 0;
			$data->save();
			$this->redirect($_SERVER["HTTP_REFERER"]);
		} else {
			$data->is_close = 1;
			$data->save();
			$this->redirect($_SERVER["HTTP_REFERER"]);
		}		
	}
    public function addmember()
	{
		$info = $this->request->param();
		//dump($info);
		$re = $this->auser->allowField(true)->save($info);
		dump($re);
		$rid = $info['role_id'];
		//dump($id);
		$this->auser->role()->save($rid);
		$this->redirect('administrator');

	}
	//添加权限
	public function addper()
	{   
        
		return $this->fetch();
	}
	//处理添加的权限
	public function doper()
	{
		$info = $this->request->param();
		$res = $this->per->where('title',$info['pername'])->select();
		//dump($res);
		if ($res){

			$this->redirect($_SERVER["HTTP_REFERER"]);
		} else {

			$this->per->title = $info['pername'];
			$this->per->save();
			$this->redirect($_SERVER["HTTP_REFERER"]);
		}		
	}
	//删除权限

	//添加角色
	public function Competence()
	{   
        
		return $this->fetch();
	}
	//处理添加的角色
	public function addrole()
	{
		$info = $this->request->param();
		$res = $this->role->where('name',$info['rolename'])->select();
		//dump($res);
		if ($res){
			$this->redirect($_SERVER["HTTP_REFERER"]);
		} else {
			$this->role->name = $info['rolename'];
			$this->role->save();
			$this->redirect($_SERVER["HTTP_REFERER"]);
		}		
	}	

	
	

}