<?php
/**
 * 模型
*/
namespace Kezhi\Model;
/**
 * 考试信息表
 * CREATE TABLE exam (
 * id INT(8) NOT NULL PRIMARY KEY AUTO_INCREMENT,
 * name VARCHAR(45) NOT NULL COMMENT '考试名称',
 * type TINYINT NOT NULL DEFAULT 0 COMMENT '考试类型',
 * title TEXT NOT NULL COMMENT '考试说明',
 * create_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录创建时间',
 * update_time TIMESTAMP NOT NULL COMMENT '最后更新时间',
 * exam_time TIMESTAMP NOT NULL COMMENT '考试开始时间',
 * status TINYINT NOT NULL DEFAULT 0 COMMENT '状态',
 * enroll_status TINYINT NOT NULL DEFAULT 0 COMMENT '报名开启状态',
 * score_status TINYINT NOT NULL DEFAULT 0 COMMENT '成绩查询开启状态'
 * )DEFAULT CHARSET=utf8 COMMENT='考试信息表';
*/
class Exam extends Model{
    const INUSE = 0;
    const DELETED = 1;
    protected $exam_types = null;

    public function __construct(){
        parent::__construct();
        global $conf;
        $conf->load(__CONF__ . '/' . $conf['rules']['exam_types_config_file']);
        $this->exam_types = $conf['exam_types'];
    }

    public function getExamTypes(){
        return is_null($this->exam_types) ? [] : $this->exam_types;
    }

    public function getExamTypeName($id){
        if(is_null($this->exam_types)){
            return '无';
        }
        foreach($this->exam_types as $v){
            if($v['id'] == $id){
                return $v['name'];
            }
        }
        return '无';
    }

    public function setEnrollState($id, $status){
        $stmt = $this->db->prepare("UPDATE exam SET enroll_status = :enroll_status WHERE id = :id LIMIT 1");
        $stmt->bindParam(':id', intval($id));
        $stmt->bindValue(':enroll_status', $status == 1 ? 1 : 0, \PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        }else{
            throw new \Exception('未知原因导致的状态修改失败', 500);
        }
    }

    public function setScoreState($id, $status){
        $stmt = $this->db->prepare("UPDATE exam SET score_status = :score_status WHERE id = :id LIMIT 1");
        $stmt->bindParam(':id', $id);
        $stmt->bindValue(':score_status', $status == 1 ? 1 : 0, \PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        }else{
            throw new \Exception('未知原因导致的状态修改失败', 500);
        }
    }

    public function add($name, $type, $title, $exam_time){
        $this->checkType($type);
        $stmt = $this->db->prepare("INSERT INTO exam (name, type, title, update_time, exam_time, status) VALUES (:name, :type, :title, :update_time, :exam_time, :status)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':title', $title);
        $stmt->bindValue(':update_time', date('YmdHis', time()));
        $stmt->bindParam(':exam_time', $exam_time);
        $stmt->bindValue(':status', self::INUSE, \PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        }else{
            throw new \Exception('未知原因导致的新增考试失败', 500);
        }
    }

    public function update($id, $name, $type, $title, $exam_time){
        $this->checkType($type);
        $stmt = $this->db->prepare("UPDATE exam SET name = :name, type = :type, title = :title, update_time = :update_time, exam_time = :exam_time WHERE id = :id LIMIT 1");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':title', $title);
        $stmt->bindValue(':update_time', date('YmdHis', time()));
        $stmt->bindParam(':exam_time', $exam_time);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        }else{
            throw new \Exception('未知原因导致的新增考试失败', 500);
        }
    }

    public function getCount(){
        $result = $this
        ->db
        ->query("SELECT COUNT(*) FROM exam WHERE status = " . self::INUSE);
        if($result === false){
            throw new \Exception('数据库查询失败', 500);
        }
        $result = $result->fetch();
        if($result === false){
            throw new \Exception('数据库查询失败', 500);
        }else{
            return intval($result[0]);
        }
    }

    public function query($id = 0){
        if($id == 0){
            throw new \Exception('请求的考试信息不存在', 404);
        }
        $stmt = $this->db->prepare("SELECT * FROM exam WHERE id = :id LIMIT 1");
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        if($stmt->execute()){
            $result = $stmt->fetch();
            if($result != false){
                if(!empty($result)){
                    return $result;
                }else{
                    throw new \Exception('请求的考试信息不存在', 404);
                }
            }else{
                throw new \Exception('数据库查询失败', 500);
            }
        }else{
            throw new \Exception('数据库查询失败', 500);
        }
    }

    public function queryAllLimit($start, $num){
        $stmt = $this->db->prepare("SELECT * FROM exam WHERE status = :status LIMIT :start,:num");
        $stmt->bindValue(':status', self::INUSE, \PDO::PARAM_INT);
        $stmt->bindValue(':start', $start, \PDO::PARAM_INT);
        $stmt->bindValue(':num', $num, \PDO::PARAM_INT);
        if($stmt->execute()){
            $result = $stmt->fetchAll();
            if($result !== false){
                return $result;
            }else{
                return [];
            }
        }else{
            throw new \Exception('数据库查询失败', 500);
        }
    }

    /**
     * 查询所有可以报名的数据
    */
    public function queryAllEnrollable(){
        $stmt = $this->db->prepare("SELECT a.id, a.name, a.type, a.exam_time, a.title, b.enroll_status FROM exam a LEFT JOIN enroll b ON b.exam_id = a.id WHERE a.status = :status AND a.enroll_status = :enroll_status");
        $stmt->bindValue(':status', self::INUSE, \PDO::PARAM_INT);
        $stmt->bindValue(':enroll_status', 1, \PDO::PARAM_INT);
        if($stmt->execute()){
            $result = $stmt->fetchAll();
            if($result !== false){
                return $result;
            }else{
                return [];
            }
        }else{
            throw new \Exception('数据库查询失败', 500);
        }
    }

    public function queryAll(){
        $stmt = $this->db->prepare("SELECT id, name, exam_time, type FROM exam WHERE status = :status");
        $stmt->bindValue(':status', self::INUSE, \PDO::PARAM_INT);
        if($stmt->execute()){
            $result = $stmt->fetchAll();
            if($result !== false){
                return $result;
            }else{
                return [];
            }
        }else{
            throw new \Exception('数据库查询失败', 500);
        }
    }

    public function delete($id = 0){
        if($id == 0){
            throw new \Exception('请求的数据不存在', 404);
        }
        $stmt = $this->db->prepare("UPDATE exam SET status = :status WHERE id = :id");
        $stmt->bindValue(':status', self::DELETED, \PDO::PARAM_INT);
        $stmt->bindParam(':id', $id);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    private function checkType($type){
        if(is_null($this->exam_types)){
            throw new \Exception('检测考试类型时发生错误', 500);
        }
        foreach($this->exam_types as $v){
            if($v['id'] == $type){
                return;
            }
        }
        throw new \Exception('检测考试类型时发生错误', 422);
    }
}
?>
