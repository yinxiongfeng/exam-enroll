<?php
namespace Kezhi\Controller;
use Kezhi\Model as Model;
use Kezhi\Lib as Lib;
class Student extends Controller{
    public function __construct(){
        parent::__construct();
        $this->smarty->assign('navbar_active', 'student');
    }

    public function student_info(){
        $page_id = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $userinfo = new Model\UserInfo();
        try{
            $total_number = $userinfo->getCount();
            $page = new Lib\Page($total_number, $page_id);
            $data = $userinfo->queryAllLimit($page->getCurrentNum(), $page->getPerPageNum());
            $this->smarty->assign('data', $data);
            $this->smarty->assign('current_page', $page->getCurrentPage());
            $this->smarty->assign('max_page_num', $page->getTotlePages());
            $this->smarty->assign('pages', $page->getPages());
        }catch(\Exception $e){
            $this->error($e->getMessage(), $e->getCode());
        }
        $this->smarty->assign('left_nav_active', 'student_info');
        $this->display('student_info.tpl');
    }

    public function edit_student_info($id){
        $id = intval($id);
        $userinfo = new Model\UserInfo();
        try{
            $photo = new Model\Photo();
            if($photo->checkHas($id)){
                $info = $photo->query($id);
            }else{
                $info = [
                    'name'  =>  'default.png'
                ];
            }
            $data = $userinfo->query($id);
            $this->smarty->assign('data', $data);
            $this->smarty->assign('info', $info);
        }catch(\Exception $e){
            $this->error($e->getMessage(), $e->getCode());
        }
        $this->display('edit_student_info.tpl');
    }

    public function pay_info(){
        $page_id = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $enroll = new Model\Enroll();
        try{
            $total_number = $enroll->getCount();
            $page = new Lib\Page($total_number, $page_id);
            $data = $enroll->getPayInfoLimit($page->getCurrentNum(), $page->getPerPageNum());
            $this->smarty->assign('data', $data);
            $this->smarty->assign('current_page', $page->getCurrentPage());
            $this->smarty->assign('max_page_num', $page->getTotlePages());
            $this->smarty->assign('pages', $page->getPages());
        }catch(\Exception $e){
            $this->error($e->getMessage(), $e->getCode());
        }
        $this->smarty->assign('left_nav_active', 'pay_info');
        $this->display('pay_info.tpl');
    }

    /**
     * 导出照片
     */
    public function photos(){
        $this->smarty->assign('left_nav_active', 'photos');
        $this->display('photos.tpl');
    }
}
?>
