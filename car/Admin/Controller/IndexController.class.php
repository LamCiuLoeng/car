<?php
namespace Admin\Controller;
use Common\Controller\BaseController;
class IndexController extends BaseController {
    public function index(){
    	$data['id'] = session('userid');
		$User = M('User');
		$this->user = $User->where($data)->find();
        $this->display();
	}
}