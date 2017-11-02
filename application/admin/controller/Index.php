<?php
namespace app\admin\controller;
use app\admin\controller\Auser;
use app\admin\model\Role;
use app\admin\model\Per;
use app\admin\model\Auser as AuserModel;
use think\Db;
use think\Session;
class Index  extends Auser
{   
    protected $auser;
	protected $is_login = ['*'];
	public function _initialize()
	{ 
	  $this->role = new Role;
	  $this->per = new Per;
      $this->auser = new AuserModel; 
	}
    public function index()
	{   
		$id = Session::get('uid')['uid'];
		//
		//var_dump($id);die;
        $info = $this->auser->where('uid',$id)->find();
        //var_dump($info);die;
        $username = $info->username;
        //var_dump($username);
        $this->assign('username',$username);

        $data = $this->auser->get($id);
        //var_dump($)
        $role = $data->role;
       // var_dump($role);
        $this->assign('role',$role);
		
		$rid = $role[0]->rid;
		$list = $this->role->get($rid);
		$per = $list->per;
		//var_dump($per);
		$this->assign('per',$per);
         foreach ($per as $val) {
         	 $per = $val->pid;
         	 $arr[] = $per;
         }
         $this->assign('arr',$arr);
         return $this->fetch();

    }
	
}