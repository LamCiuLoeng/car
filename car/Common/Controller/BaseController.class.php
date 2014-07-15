<?php
namespace Common\Controller;
use Think\Controller;
class BaseController extends Controller {
    public function _before_index(){
        if(!session('?login')){
            $this->redirect('/Admin/Auth/login',NULL,0);
        }
    }
}