<?php
/** 控制器 */
namespace Kezhi\Controller;
use Smarty;
use Kezhi\Common;
/**
 * 控制器基类
*/
class Controller{
    /** @var Object $smarty smarty框架实例*/
    protected $smarty;
    /**
     * 构造函数，实例化smarty框架并进行配置
    */
    public function __construct(){
        $this->smarty = new Smarty;
        $this->smarty->setTemplateDir(__WEB__ . 'templates/');
        $this->smarty->setCompileDir(__WEB__ . 'templates_c/');
        $this->smarty->setConfigDir(__WEB__ . 'configs/');
        $this->smarty->setCacheDir(__WEB__ . 'cache/');
        // isset($_GET['token']) ? session_id($_GET['token']) : $_SERVER['QUERY_STRING'] == '/index.php/auth' ? $this->redirect('/index.php/auth') : print( 'I don\'t know to do what ');
        $this->checkAuth();
    }

    /**
     * 检查权限
    */
    protected function checkAuth(){
        $auth = new \Kezhi\Common\Auth;
        if($auth->check() === false){
            $this->redirect('/index.php/auth');
        }else{

        }
    }

    /**
     * 重定向操作
     *
     * @param string $url 重定向到哪里
    */
    private function redirect($url){
        header('Location: ' . $url);
        exit;
    }
}
?>
