<?php
/** 公共 类库 */
namespace Kezhi\Common;
/**
 * 权限认证类
*/
class Auth {
    protected $rules = [
        'admin' =>  [
            '/\/index.php\/user/',
            '/\/index.php$/'
        ],
        'student'   =>  [
            '/\/index.php\/user/',
            '/\/index.php$/',
            '/\/index.php\/profile/',
            '/\/index.php\/change_password/',
            '/\/index.php\/modify_photo/',
            '/\/api.php\/user\/change_password/',
            '/\/index.php\/enroll$/',
            '/\/index.php\/enroll_info/',
            '/\/index.php\/score/',
            '/\/api.php\/enroll$/',
            '/\/api.php\/enroll\/cancle/',
            '/\/api.php\/photo/',
            '/\/index.php\/photo/',
            '/\/index.php\/image/'
        ],
        'teacher'   =>  [
            '/\/index.php\/user/',
            '/\/index.php$/',
            '/\/index.php\/exam$/',
            '/\/index.php\/exam\/add/',
            '/\/index.php\/diploma/',
            '/\/index.php\/room$/',
            '/\/index.php\/room\/add/',
            '/\/index.php\/room\/allot/',
            '/\/index.php\/change_password/',
            '/\/api.php\/user\/change_password/',
            '/\index.php\/import\/student_account/',
            '/\/index.php\/import\/pay_info/',
            '/\/index.php\/import\/photos/',
            '/\/index.php\/import\/score/',
            '/\/index.php\/student_info/',
            '/\/index.php\/photos/',
            '/\/index.php\/score/',
            '/\/index.php\/pay_info/',
            '/\/api.php\/import\/student_account/',
            '/\/index.php\/test/',
            '/\/api.php\/student\/info/',
            '/\/api.php\/student\/delete/',
            '/\/index.php\/student\/edit\/student_info/',
            '/\/api.php\/exam\/add/',
            '/\/api.php\/exam\/info/',
            '/\/api.php\/exam\/edit/',
            '/\/index.php\/exam\/edit/',
            '/\/api.php\/exam\/delete/',
            '/\/index.php\/room\/type/',
            '/\/index.php\/building/',
            '/\/api.php\/building\/add/',
            '/\/api.php\/building\/delete/',
            '/\/api.php\/building\/edit/',
            '/\/api.php\/room\/add/',
            '/\/api.php\/room\/delete/',
            '/\/api.php\/room\/edit/',
            '/\/index.php\/room\/edit/',
            '/\/api.php\/exam\/score\/state/',
            '/\/api.php\/exam\/enroll\/state/',
            '/\/index.php\/export/',
            '/\/api.php\/export/',
            '/\/index.php\/download\//',
            '/\/api.php\/photo/',
            '/\/index.php\/photo/',
            '/\/index.php\/image/',
            '/\/index.php\/zip/',
            '/\/api.php\/import\/student_payinfo/',
            '/\/api.php\/enroll\/pay_status/',
            '/\/api.php\/room\/all/',
            '/\/api.php\/exam\/all/',
            '/\/api.php\/exam\/allot/',
            '/\/index.php\/allot_info/'
        ],
        'auth'  =>  [
            '/\/index.php\/auth/',
            '/\/api.php\/auth$/'
        ]
    ];

    /**
     * 检查当前访问权限
     * 根据$_SERVER['PHP_SELF'] 和 $_SESSION['role']进行判断是否拥有访问权限
     * @return bool 拥有访问权限返回true，没有返回false
    */
    public function check(){
        $uri = $_SERVER['PHP_SELF'];
        if(isset($_SESSION['role']) === false){
            if($this->match($uri, $this->rules['auth']) === false){
                return false;
            }else{
                return true;
            }
        }else{
            if($this->match($uri, $this->rules[$_SESSION['role']]) === false && $this->match($uri, $this->rules['auth']) === false){
                return false;
            }else{
                return true;
            }
        }
    }

    /**
     * 匹配uri与规则
     * 遍历规则$rules ,匹配rui
     * @param string $uri 要匹配的uri
     * @param Array  $rules 规则集
     * @return bool 成功匹配到返回true，否则返回false
    */
    private function match($uri, Array $rules){
        foreach($rules as $rule){
            if(preg_match($rule, $uri) == 0){

            }else{
                return true;
            }
        }
        return false;
    }
}
?>
