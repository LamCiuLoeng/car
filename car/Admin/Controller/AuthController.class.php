<?php
namespace Admin\Controller;
use Think\Controller;
class AuthController extends Controller {
    
    public function login(){
        $this->display();
	}
    
    public function check()
    {
        $User = M('User');
        $map['name'] = I('name',NULL);
        $map['password'] = I('password',NULL);

        if(is_null($map['name']) || is_null($map['password'])){
            $this->error('User name or password can not be blank!',U('login'));
        }
        
        $user = $User->where($map)->find();
        if(!$user || is_null($user)){
            $this->error('Wrong user name or password!',U('login'));
        }else{
            session('login','YES');
			session('userid',$user['id']);
            $this->redirect('Index/index',NULL,0);
        }
        
    }
    
    
    public function logout()
    {
        if(session('?login')){
            session('login',null); 
        }
        $this->success('',U('login'),2);
    }
    
    public function register()
    {
        $this->display();
    }
    
    
    public function save_register()
    {
        $User = M('User');
        $map['name'] = I('name',NULL);
        
        if(!$map['name'] || is_null($map['name'])){
            $this->error('User name can not be blank!',U('register'));
        }
        
        $user = $User->where($map)->find();
        if($user){  #if it's exist
            $this->error(L('The user already exist!'),U('register'));
        }
        
        $map['password'] = I('password',NULL);
        if(!$map['password'] || is_null($map['password'])){
            $this->error('Password can not be blank!',U('register'));
        }
        
		$map['address'] = I('address',NULL);
		if(!is_null($map['address'])){
			$map['code'] = $map['address'].$this->gen_code();
		}
		
        #save user
        $map['email'] = I('email',NULL);
        $datetime = new \DateTime();
        $map['create_time'] = $datetime->format('Y\-m\-d\ h:i:s');
        $map['update_time'] = $datetime->format('Y\-m\-d\ h:i:s');
        $map['create_by_id'] = 1;
        $map['update_by_id'] = 1;
        $map['active'] = 0;
        $User->data($map)->add();
        $this->success('Save the user successfully!',U('login'),2);
    }

	private function gen_code()
	{
		$k = '';
		for($i=0;$i<6;$i++){
			$k = $k.chr(rand(65,90));
		}
		return $k;
	}
    
}