<?php
namespace app\admin\Controller;
use app\admin\controller\Auser;
use app\admin\model\Order as OrderModel;
use think\Db;
use think\Request;
class Order extends Auser
{
	protected $is_login = ['*'];
	//订单处理
	public function order_handling(Request $request)
	{   
	  $list =Db::name('order')->paginate(5);
       $order = new OrderModel;
       $status = empty($request->param('status'))? '%' : $request->param('status');
       $arr = $order->selectdata($status);
       // if(!empty($list))
       // {
       // 	 foreach ($list as $k => $v) {
       // 	 	$list[$k]['status'] = $order->getStatusAttr($v['status']);

       	 	
       // 	 }
      		 $page = $list->render();
      		 $this->assign('arr',$arr);
      		 $this->assign('list',$list);
	         $this->assign('page',$page);
	   //       $id = $request->param('id');
	   //       $str = $order->del($id);
	   //       if ($str) {
				// 	echo "<script>alert('删除成功');history.back();</script>";
				// } else {
				// 	echo "<script>alert('删除失败');history.back();</script>";
				// }
	       
	       		return $this->fetch();
	}
	//交易金额
     public function amounts()
    {   
    	$re=Db::name('order')->where('status',4)->paginate(2);
        $order = new OrderModel;
        $page = $re->render();
    	$this->assign('re',$re);
        $this->assign('page',$page);
    	return $this->fetch();
    }





	
} 