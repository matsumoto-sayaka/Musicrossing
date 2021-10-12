<?php
require_once(ROOT_PATH .'/Models/Db.php');

class User extends Db {
    private $tablePhysical = 'users';
    private $tableLogical = 'ユーザ';
    public function __construct($pdo = null){
        parent::__construct($pdo);
    }

     /**
     * partとworkの削除
     */
    private function deleteSubDate($user_id) {
        $tableNames = array("part", "work");
        $paramsSql = array(":user_id" => $user_id);
        foreach($tableNames as $tablename) {
            $sql = "delete from ".$tablename." where user_id = :user_id";
            $sth = $this->pdo->prepare($sql);
            $result = $sth->execute($paramsSql);
        }
    }

    
    /**
     * ユーザ情報、担当パート、業務領域　を登録する
     * 
     * @return DynamicProperty $results 
     */
    public function insert() {

        $results = $this->initResults();
        $this->transaction();

        try {
            $post =$this->request['post'];

            // ユーザ情報の登録
            $user_id = $this->insertUser();

            // partとworkの登録
            $this->insertSubDate($user_id);

            $this->commit();

        } catch (PDOException $e) {
            $this->rollback();
            $this->getErrorInfo(sprintf($this->sqlError['insert'], $this->tablePhysical, $this->tableLogical), $e);
        }

        return $results;
    }
        
    /**
     * ユーザ情報、担当パート、業務領域　を更新する
     * 
     * @return DynamicProperty $results 
     */
    public function update() {
 
        $result = false;
        $this->transaction();

        try {
            // ユーザ情報の更新
            $user_id = $this->updateUser();

            // partとworkの登録
            $this->deleteSubDate($user_id);

            // partとworkの登録
            $this->insertSubDate($user_id);

            $this->commit();

            $result = true;

        } catch (PDOException $e) {
            $this->rollback();
            $this->getErrorInfo(sprintf($this->sqlError['update'], $this->tablePhysical, $this->tableLogical), $e);

        } finally {
            return $result;
        }
    }

    /**
     * partとworkの登録
     */
    private function insertSubDate($user_id) {

        $params = $this->request['post'];

        // 担当パート
        if(isset($params['part']) && count($params['part']) > 0) {
            $parts = $params['part'];
            $partCount = 0;
            $partMaxCount = count($params['part']);
            $sqlPart = "";
            $sqlPart .= "INSERT INTO part (user_id , part_id) VALUES ";
            $sqlPartParam = array();
            foreach($parts as $key => $value) {
                $partCount++;
                $sqlPart .= "(:user_id_".$partCount.", :part_id_".$partCount.")";
                if($partCount < $partMaxCount) {
                    $sqlPart .= ",";
                }else{
                    $sqlPart .= ";";
                }
                $sqlPartParam[":user_id_".$partCount] = $user_id;
                $sqlPartParam[":part_id_".$partCount] = $value;
            }
            $sth = $this->pdo->prepare($sqlPart);
            $resultPart = $sth->execute($sqlPartParam);
        }

        // 業務領域
        if(isset($params['work']) && count($params['work']) > 0) {
            $works = $params['work'];
            $workCount = 0;
            $workMaxCount = count($params['work']);
            $sqlWork = "";
            $sqlWork .= "INSERT INTO work (user_id , work_id) VALUES ";
            $sqlWorkParam = array();
            foreach($works as $key => $value) {
                $workCount++;
                $sqlWork .= "(:user_id_".$workCount.", :work_id_".$workCount.")";
                if($workCount < $workMaxCount) {
                    $sqlWork .= ",";
                }else{
                    $sqlWork .= ";";
                }
                $sqlWorkParam[":user_id_".$workCount] = $user_id;
                $sqlWorkParam[":work_id_".$workCount] = $value;
            }
            $sth = $this->pdo->prepare($sqlWork);
            $resultWork = $sth->execute($sqlWorkParam);
        }
    }

    /**
     * ユーザ情報の登録
     */
    private function insertUser() {
        $sql = $this->insertSql();

        $sth = $this->pdo->prepare($sql);
        $params = $this->request['post'];

        $paramsSql = array(
            ':nickname' => $params['nickname'],
            ':gender' => $params['gender'],
            ':age' => $params['age'],
            ':state_id' => $params['state_id'],
            ':self_introduction' => $params['self_introduction'],
            ':email' => $params['email'],
            ':password' => md5($params['password']),
            ':thumbnail_path' => $params['thumbnail_path']
        );

        $result = $sth->execute($paramsSql);
        $lastInsertId = $this->pdo->lastInsertId();
        return $lastInsertId;
    }

    /**
     * ユーザ情報の登録
     */
    private function updateUser() {
        $sql = $this->updateSql();
        $sth = $this->pdo->prepare($sql);
        $params = $this->request['post'];
        $paramsSql = array(
            ':nickname' => $params['nickname'],
            ':gender' => $params['gender'],
            ':state_id' => $params['state_id'],
            ':age' => $params['age'],
            ':self_introduction' => $params['self_introduction'],
            ':thumbnail_path' => $params['thumbnail_path'],
            ':id' => $params['user_id'],
        );
        $result = $sth->execute($paramsSql);
        return $params['user_id'];
    }

    private function insertSql() {
        $sql = "";
        $sql .= "INSERT INTO users ";
        $sql .= "( ";
        //$sql .= "    id "; // 自動附番のため必要なし
        $sql .= "     nickname ";
        $sql .= "   , gender ";
        $sql .= "   , age ";
        $sql .= "   , state_id ";
        $sql .= "   , self_introduction ";
        $sql .= "   , email ";
        $sql .= "   , password ";
        $sql .= "   , thumbnail_path ";
        //$sql .= "   , created_at ";// 初期値はカレント日時なので必要なし
        //$sql .= "   , updated_at ";// 初期値はnullのため必要なし
        $sql .= "   , del_flg ";
        $sql .= ") ";
        $sql .= "VALUES( ";
        // $sql .= "    :id ";
        $sql .= "     :nickname ";
        $sql .= "   , :gender ";
        $sql .= "   , :age ";
        $sql .= "   , :state_id ";
        $sql .= "   , :self_introduction ";
        $sql .= "   , :email ";
        $sql .= "   , :password ";
        $sql .= "   , :thumbnail_path ";
        // $sql .= "   , :created_at ";
        // $sql .= "   , :updated_at ";
        $sql .= "   , 0 ";
        $sql .= ") ";
        return $this->formatHalfWidthSpace($sql);
    }



    public function partMstAll():Array {
        $sql = 'SELECT * FROM part_mst';
        $sth = $this->pdo->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
       
    public function workMstAll():Array {
        $sql = 'SELECT * FROM work_mst';
        $sth = $this->pdo->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
       
    public function stateMstAll():Array {
        $sql = 'SELECT * FROM state_mst';
        $sth = $this->pdo->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function userAll() {
        $sql = "";
        $sql = 'SELECT * FROM users WHERE del_flg = 0';
        $sth = $this->pdo->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function partAll() {
        $sql = 'SELECT * FROM part';
        $sth = $this->pdo->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function workAll() {
        $sql = 'SELECT * FROM work';
        $sth = $this->pdo->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function findByUser($id) {
        $sql = 'SELECT * FROM users WHERE id = ?';
        $sth = $this->pdo->prepare($sql);
        $data[] = $id;
        $sth->execute($data);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function findByPart($id) {
        $sql = 'SELECT * FROM part WHERE user_id = ?';
        $sth = $this->pdo->prepare($sql);
        $data[] = $id;
        $sth->execute($data);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function findByWork($id) {
        $sql = 'SELECT * FROM work WHERE user_id = ?';
        $sth = $this->pdo->prepare($sql);
        $data[] = $id;
        $sth->execute($data);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function loginUser($email, $password) {
        $sql = 'SELECT * FROM users WHERE email = ? AND password = ?';
        $sth = $this->pdo->prepare($sql);
        $data[] = $email;
        $data[] = $password;
        $sth->execute($data);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
      
    



    public function exchangeAll($h_id, $g_id) {
        $sql = 'SELECT * FROM exchanges WHERE (host_user_id = ? AND guest_user_id = ?) OR (host_user_id = ? AND guest_user_id = ?)';
        $sth = $this->pdo->prepare($sql);
        $data[] = $h_id;
        $data[] = $g_id;
        $data[] = $g_id;
        $data[] = $h_id;
        $sth->execute($data);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function exchangeCreate($host_user_id, $guest_user_id, $body_host_id, $group_name, $body) {
        try {
            $this->pdo->beginTransaction();

            $sql = 'INSERT INTO exchanges (host_user_id, guest_user_id, body_host_id, group_name, body) VALUES (?, ?, ?, ?, ?)';
            $sth = $this->pdo->prepare($sql);
            $data[] = $host_user_id;
            $data[] = $guest_user_id;
            $data[] = $body_host_id;
            $data[] = $group_name;
            $data[] = $body;
            $sth->execute($data);

            $this->pdo->commit();

        } catch (Exception $e) {
            $this->pdo->rollBack();

            echo 'ただいま障害によりエラーが発生しております。';
            exit();
        }
    }

    public function groupUser($h_id, $g_id) {
        $sql = 'SELECT * FROM users WHERE id = ? OR id = ? ORDER BY id ASC';
        $sth = $this->pdo->prepare($sql);
        $data[] = $h_id;
        $data[] = $g_id;
        $sth->execute($data);
        $result = $sth->fetchALL(PDO::FETCH_ASSOC);
        return $result;
    }

    public function exchangeUserAll($id) {
        $sql = 'SELECT exchanges.* FROM exchanges INNER JOIN (SELECT group_name, MAX(created_at) created_at FROM exchanges GROUP BY group_name) AS exchanges_2 ON exchanges.group_name = exchanges_2.group_name AND exchanges.created_at = exchanges_2.created_at WHERE (exchanges.host_user_id = ? OR exchanges.guest_user_id = ?)';
        $sth = $this->pdo->prepare($sql);
        $data[] = $id;
        $data[] = $id;
        $sth->execute($data);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }



    
    /**
     * ユーザ情報を取得する
     * 
     * @return DynamicProperty $results 
     */
    public function select() {

        $results = $this->initResults();
        $this->transaction();
        
        try {
            $sql = $this->selectSql();
            $sth = $this->pdo->prepare($sql);
            $params = $this->request['post'];
            $paramsSql = array(':email' => $params['email']);
            // SQL実行結果                   : $sth->execute($params)
            // SQL実行件数                   : $sth->rowCount()
            // SELECT実行で取得した全行       :  $sth->fetchAll(PDO::FETCH_ASSOC)
            // INSERT登録された際に自動附番ID :  $this->pdo->lastInsertId()
            $this->makeResults(
                $results,
                $sth->execute($paramsSql),
                $sth->rowCount(),
                $sth->fetchAll(PDO::FETCH_ASSOC),
                null
            );
            $this->commit();
        } catch (PDOException $e) {
            $this->rollback();
            $this->getErrorInfo(sprintf($this->sqlError['select'], $this->tablePhysical, $this->tableLogical), $e);
        }

        return $results;
    }


    private function selectSql() {
        $sql = "";
        $sql .= "SELECT ";
        $sql .= "     id ";
        $sql .= "   , nickname ";
        $sql .= "   , gender ";
        $sql .= "   , age ";
        $sql .= "   , state_id ";
        $sql .= "   , self_introduction ";
        $sql .= "   , email ";
        $sql .= "   , password ";
        $sql .= "   , thumbnail_path ";
        $sql .= "   , created_at ";
        $sql .= "   , updated_at ";
        $sql .= "   , del_flg ";
        $sql .= "FROM ";
        $sql .= "     users ";
        $sql .= "WHERE ";
        $sql .= "     email = :email ";
        return $this->formatHalfWidthSpace($sql);
    }

    private function updateSql() {
        $sql = "";
        $sql .= "UPDATE ";
        $sql .= "     users ";
        $sql .= "SET ";
        $sql .= "     nickname              =   :nickname ";
        $sql .= "   , gender                =   :gender ";
        $sql .= "   , age                   =   :age ";
        $sql .= "   , state_id              =   :state_id ";
        $sql .= "   , self_introduction     =   :self_introduction ";
        // $sql .= "   , email                 =   :email ";
        // $sql .= "   , password              =   :password ";
        $sql .= "   , thumbnail_path        =   :thumbnail_path ";
        // $sql .= "   , created_at            =   :created_at ";
        $sql .= "   , updated_at            =   CURRENT_TIMESTAMP() ";
        // $sql .= "   , del_flg               =   :del_flg ";
        $sql .= "WHERE ";
        $sql .= "     id                    =   :id ";
        return $this->formatHalfWidthSpace($sql);
    }

    /**
     * ■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
     * ユーザ情報の検索
     * ■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
     */
    public function getUsersInfo() {

        $post = $this->request['post'];

        // ■■■■■■■　０１　■■■■■■■
        // チェックされた「担当パート」と「業務領域」が登録されているユーザIDを全て取得
        $part_work_Sql = "";
        $part_work_UserID_IN_Clause = "";
        $part_work_Exists_Flg = false;
        $part_work_Result = false;
        $part_work_UserID_Array = array();
        $part_work_UserID_MaxCount = 0;
        $part_work_Sql = $this->selectPartAndWorkSql_for_user_id($part_work_Exists_Flg);

        $userID_in_clause = "";
        $sqlParamsUsers = array();

        if($part_work_Exists_Flg) {
            $part_work_sth = $this->pdo->prepare($part_work_Sql);
            $part_work_Result = $part_work_sth->execute();
            $part_work_UserID_Array = $part_work_sth->fetchAll(PDO::FETCH_ASSOC);
            $part_work_UserID_MaxCount = count($part_work_UserID_Array);
    
            // 取得したユーザIDからIN句を作成
            if($part_work_Result && $part_work_UserID_MaxCount > 0) {
                $part_work_UserID_Count = 0;
                $part_work_UserID_IN_Clause = " ( ";
                foreach($part_work_UserID_Array as $k => $v) {
                    $part_work_UserID_Count++;
                    $part_work_UserID_IN_Clause .= " ".$v['user_id']." ";
                    if($part_work_UserID_Count < $part_work_UserID_MaxCount) {
                        $part_work_UserID_IN_Clause .= ", ";
                    }
                }
                $part_work_UserID_IN_Clause .= " ) ";
            }

            $userID_in_clause = $part_work_UserID_IN_Clause;
        }

        // ■■■■■■■　０２　■■■■■■■
        // ユーザIDのIN句にて、「ユーザ情報」　を取得
        $users = array();
        $part = array();
        $work = array();
        $partCount_by_Each_userID = array();
        $wordCount_by_Each_userID = array();
        $part_convenience = array();
        $work_convenience = array();

        $usersSelectResult = false;
        $partSelectResult = false;
        $workSelectResult = false;
        $partCount_by_Each_userID_Result = false;
        $workCount_by_Each_userID_Result = false;
        $part_convenience_Result = false;
        $work_convenience_Result = false;

        $usersSelectCount = 0;
        $partSelectCount = 0;
        $workSelectCount = 0;
        $part_convenience_Count = 0;
        $work_convenience_Count = 0;

        // 担当パート、業務領域　の検索条件で、ユーザ情報が０件の場合
        // 検索結果は０件という情報を画面に返却する
        if($part_work_Result && $part_work_UserID_MaxCount == 0) {
            $usersSelectResult = true;
            $partSelectResult = true;
            $workSelectResult = true;
            $partCount_by_Each_userID_Result = true;
            $workCount_by_Each_userID_Result = true;
            $part_convenience_Result = true;
            $work_convenience_Result = true;
        }else{
            // ユーザ情報
            $sql = $this->selectUsersInfoSql($userID_in_clause);
            $sth = $this->pdo->prepare($sql);
            $paramsName = array('gender', 'age', 'state_id');
            foreach($paramsName as $pn)  {
                if($post[$pn] != 0) {
                    $sqlParamsUsers[':'.$pn] = $post[$pn];
                }
            }
            $usersSelectResult = $sth->execute($sqlParamsUsers);
            $users = $sth->fetchAll(PDO::FETCH_ASSOC);
            $usersSelectCount = count($users);
        
            // ■■■■■■■　０３　■■■■■■■
            // ０２で取得した「ユーザ情報」から、再度ユーザIDのIN句を作成し、それを検索条件として「担当パート」「業務領域」を取得
            $remake_userID_in_clause = "";
            if(isset($users) && count($users)) {
                $sqlWhereInClause = " ( ";
                for($i = 0; $i < count($users); $i++) {
                    $sqlWhereInClause .= " ".$users[$i]['u1_id']." ";
                    if($i + 1 < count($users)) { 
                        $sqlWhereInClause .= " , ";
                    }
                }
                $sqlWhereInClause .= " ) ";
                $remake_userID_in_clause = $sqlWhereInClause;
            }
            // 担当パート
            $part = $this->partAll_by_userID($remake_userID_in_clause, $partSelectResult);
            $partCount_by_Each_userID = $this->partCount_by_Each_userID($remake_userID_in_clause, $partCount_by_Each_userID_Result);
            $partSelectCount = count($part);

            $part_convenience = $this->getPartInfo_convenience($remake_userID_in_clause, $part_convenience_Result);
            $part_convenience_Count = count($part_convenience);

            // 業務領域
            $work = $this->workAll_by_userID($remake_userID_in_clause, $workSelectResult);
            $workCount_by_Each_userID = $this->workCount_by_Each_userID($remake_userID_in_clause, $workCount_by_Each_userID_Result);
            $workSelectCount = count($work);

            $work_convenience = $this->getWorkInfo_convenience($remake_userID_in_clause, $work_convenience_Result);
            $work_convenience_Count = count($work_convenience);
        }


        // ■■■■■■■　０４　■■■■■■■
        // 画面へのデータ返却用プロパティへ、「ユーザ情報」「担当パート」「業務領域」を設定し、画面へ返却
        $results = new DynamicProperty();
        $results->users = $users;
        $results->part = $part;
        $results->work = $work;
        $results->partCount_by_Each_userID = $partCount_by_Each_userID;
        $results->workCount_by_Each_userID = $workCount_by_Each_userID;

        $results->part_convenience = $part_convenience;
        $results->work_convenience = $work_convenience;

        $results->usersSelectResult = $usersSelectResult;
        $results->partSelectResult = $partSelectResult;
        $results->workSelectResult = $workSelectResult;
        $results->partCount_by_Each_userID_Result = $partCount_by_Each_userID_Result;
        $results->workCount_by_Each_userID_Result = $workCount_by_Each_userID_Result;

        $results->part_convenience_Result = $part_convenience_Result;
        $results->work_convenience_Result = $work_convenience_Result;

        $results->usersSelectCount = $usersSelectCount;
        $results->partSelectCount = $partSelectCount;
        $results->workSelectCount = $workSelectCount;

        $results->part_convenience_Count = $part_convenience_Count;
        $results->work_convenience_Count = $work_convenience_Count;

        return $results;

    }
    
    /**
     * ■■■■■■■■■■■■■■■　担当パート情報の取得　■■■■■■■■■■■■■■■
     * 下記の例のように　「ユーザID、パートID、パート名」　が1行で取得出来る
     * user_id	    all_id	    all_name
     *      1	    1、3	    ボーカル、ベース
     *      3	    2、4	    ギター、ドラム
     *      5	    1、5	    ボーカル、ピアノ
     */
    public function getPartInfo_convenience($userID_in_clause, &$result){
        $sql = "";
        $sql .= "select ";
        $sql .= "    t1.p1_user_id user_id ";
        $sql .= "    ,GROUP_CONCAT(t1.p1_part_id SEPARATOR '、') all_id ";
        $sql .= "    ,GROUP_CONCAT(t1.pm1_part SEPARATOR '、') all_name ";
        $sql .= "from ";
        $sql .= "( ";
        $sql .= "select ";
        $sql .= "     p1.user_id p1_user_id  ";
        $sql .= "    ,p1.part_id p1_part_id ";
        $sql .= "    ,pm1.part pm1_part ";
        $sql .= "from ";
        $sql .= "    part p1 ";
        $sql .= "left outer join ";
        $sql .= "    part_mst pm1 ";
        $sql .= "on ";
        $sql .= "    p1.part_id = pm1.id ";
        $sql .= "order by ";
        $sql .= "     p1.user_id asc ";
        $sql .= "    ,p1.part_id asc ";
        $sql .= ") t1 ";
        if($userID_in_clause != "") {
            $sql .= "where ";
            $sql .= "    t1.p1_user_id in ".$userID_in_clause;
        }
        $sql .= "group by ";
        $sql .= "    t1.p1_user_id ";
        $sql = $this->formatHalfWidthSpace($sql);
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute();
        $arr = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $arr;
    }

        /**
     * ■■■■■■■■■■■■■■■　業務領域情報の取得　■■■■■■■■■■■■■■■
     * 下記の例のように　「ユーザID、業務領域ID、業務領域名」　が1行で取得出来る
     * user_id	    all_id	    all_name
     *      1	    1、3	    作詞、編曲
     *      3	    2、4	    作曲、演奏
     *      5	    7、8	    レコーディング、ベースミックス・マスタリング
     */
    public function getWorkInfo_convenience($userID_in_clause, &$result){
        $sql = "";
        $sql .= "select ";
        $sql .= "    t1.w1_user_id user_id ";
        $sql .= "    ,GROUP_CONCAT(t1.w1_work_id SEPARATOR '、') all_id ";
        $sql .= "    ,GROUP_CONCAT(t1.wm1_work SEPARATOR '、') all_name ";
        $sql .= "from ";
        $sql .= "( ";
        $sql .= "select ";
        $sql .= "     w1.user_id w1_user_id  ";
        $sql .= "    ,w1.work_id w1_work_id ";
        $sql .= "    ,wm1.work wm1_work ";
        $sql .= "from ";
        $sql .= "    work w1 ";
        $sql .= "left outer join ";
        $sql .= "    work_mst wm1 ";
        $sql .= "on ";
        $sql .= "    w1.work_id = wm1.id ";
        $sql .= "order by ";
        $sql .= "     w1.user_id asc ";
        $sql .= "    ,w1.work_id asc ";
        $sql .= ") t1 ";
        if($userID_in_clause != "") {
            $sql .= "where ";
            $sql .= "    t1.w1_user_id in ".$userID_in_clause;
        }
        $sql .= "group by ";
        $sql .= "    t1.w1_user_id ";
        $sql = $this->formatHalfWidthSpace($sql);
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute();
        $arr = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $arr;
    }

    public function partAll_by_userID($userID_in_clause, &$result) {
        $sql = '';
        $sql .= ' select p1.id p1_id, p1.user_id p1_user_id, p1.part_id p1_part_id, mp1.id mp1_id, mp1.part mp1_part from part p1 ';
        $sql .= ' left outer join part_mst mp1 on p1.part_id = mp1.id ';
        if($userID_in_clause != "") {
            $sql .= ' where p1.user_id in '.$userID_in_clause.' ';
        }
        $sql .= ' order by p1.id asc ';
        $sql = $this->formatHalfWidthSpace($sql);
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute();
        $part = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $part;
    }

    public function workAll_by_userID($userID_in_clause, &$result) {
        $sql = '';
        $sql .= ' select w1.id w1_id, w1.user_id w1_user_id, w1.work_id w1_work_id, mw1.id mw1_id, mw1.work mw1_work from work w1 ';
        $sql .= ' left outer join work_mst mw1 on w1.work_id = mw1.id ';
        if($userID_in_clause != "") {
            $sql .= ' where w1.user_id in '.$userID_in_clause.' ';
        }
        $sql .= ' order by w1.id asc ';
        $sth = $this->pdo->prepare($sql);
        $sql = $this->formatHalfWidthSpace($sql);
        $result = $sth->execute();
        $work = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $work;
    }

    public function partCount_by_Each_userID($userID_in_clause, &$result) {
        $sql = '';
        $sql .= ' select p2.user_id p2_user_id, p2.count p2_count from (select user_id, count(*) count from part group by user_id) p2 ';
        if($userID_in_clause != "") {
            $sql .= ' where p2.user_id in '.$userID_in_clause.' ';
        }
        $sql .= ' order by p2.user_id asc ';
        $sql = $this->formatHalfWidthSpace($sql);
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute();
        $partCount_by_Each_userID = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $partCount_by_Each_userID;
    }

    public function workCount_by_Each_userID($userID_in_clause, &$result) {
        $sql = '';
        $sql .= ' select w2.user_id w2_user_id, w2.count w2_count from (select user_id, count(*) count from work group by user_id) w2 ';
        if($userID_in_clause != "") {
            $sql .= ' where w2.user_id in '.$userID_in_clause.' ';
        }
        $sql .= ' order by w2.user_id asc ';
        $sql = $this->formatHalfWidthSpace($sql);
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute();
        $workCount_by_Each_userID = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $workCount_by_Each_userID;
    }

    private function selectPartAndWorkSql_for_user_id(&$existsFlg = false) {

        $sql = "";
        $paramsPost = $this->request['post'];
        $existsFlg_part = false;
        $existsFlg_work = false;

        if(
            (isset($paramsPost['part']) && count($paramsPost['part']) > 0 ) ||
            (isset($paramsPost['work']) && count($paramsPost['work']) > 0 )
        )
        {
            $sql .= " select * from ( ";
            $existsFlg = true;
        }

        $tableNames = array(1 => 'part', 2 => 'work');
        foreach($tableNames as $tableName) {

            $sqlWhere = "";

            // 担当パート　もしくは　業務領域　のSQLを作成
            if(isset($paramsPost[$tableName]) && count($paramsPost[$tableName]) > 0) {
                $params = $paramsPost[$tableName];
                $paramsCount = 0;
                $paramsMaxCount = count($params);
                $sqlWhere .= " ( ";
                foreach($params as $k => $v) {
                    $paramsCount++;
                    $sqlWhere .= " ".$tableName."_id = ".$v." ";
                    if($paramsCount < $paramsMaxCount) {
                        $sqlWhere .= " or ";
                    }
                }
                $sqlWhere .= " ) ";
                if($tableName == 'work' && $existsFlg_part) {
                    $sql.= " UNION ";
                }
                $sql .= "( select user_id from ".$tableName." where ".$sqlWhere." group by user_id )";
                if($tableName == 'part') {
                    $existsFlg_part = true;
                }elseif($tableName == 'work'){
                    $existsFlg_work = true;
                }
                
            }
        }

        $sql .= " ) AS t1 order by t1.user_id asc ";
        return $this->formatHalfWidthSpace($sql);
    }

    private function selectUsersInfoSql($userID_in_clause) {

        $sql = "";
        $sql .= "SELECT ";

        // ■■■■■■■　取得したいデータ　■■■■■■■
        // ●ユーザ情報
        $sql .= "      u1.id                    AS      u1_id ";
        $sql .= "    , u1.nickname              AS      u1_nickname ";
        $sql .= "    , u1.gender                AS      u1_gender ";
        $sql .= "    , u1.age                   AS      u1_age ";
        $sql .= "    , u1.state_id              AS      u1_state_id ";
        $sql .= "    , u1.self_introduction     AS      u1_self_introduction ";
        $sql .= "    , u1.email                 AS      u1_email ";
        $sql .= "    , u1.password              AS      u1_password "; //パスワードは取得されたらまずいかな？一応コメントアウト
        $sql .= "    , u1.thumbnail_path        AS      u1_thumbnail_path ";
        $sql .= "    , u1.created_at            AS      u1_created_at ";
        $sql .= "    , u1.updated_at            AS      u1_updated_at ";
        $sql .= "    , u1.del_flg               AS      u1_del_flg ";
        
        // ●都道府県情報
        $sql .= "    , ms1.id                   AS      ms1_id ";
        $sql .= "    , ms1.name                 AS      ms1_name ";

        // ■■■■■■■　取得したいデータのあるテーブル　■■■■■■■
        // ●ユーザテーブル
        $sql .= "FROM ";
        $sql .= "      users                    AS      u1 ";
        
        // ●都道府県マスタ
        $sql .= "LEFT OUTER JOIN ";
        $sql .= "      state_mst                AS      ms1 ";
        $sql .= "ON ";
        $sql .= "      u1.state_id              =       ms1.id ";
        
        // ■■■■■■■　検索条件（WHERE句）　■■■■■■■
        // ●ユーザ情報が論理削除されていない
        $sql .= "WHERE ";
        $sql .= "      u1.del_flg               =       0 ";

        $paramsPost = $this->request['post'];

        // ●ユーザ情報のID(users.id)
        if($userID_in_clause != "") {
            $sql .= "AND ";
            $sql .= "      u1.id                IN      ".$userID_in_clause." ";
        }

        // ●ユーザ情報の性別(users.gender)
        if($paramsPost['gender'] != 0) {
            $sql .= "AND ";
            $sql .= "      u1.gender            =       :gender ";
        }

        // ●ユーザ情報の年代(users.age)
        if($paramsPost['age'] != 0) {
            $sql .= "AND ";
            $sql .= "      u1.age               =       :age ";
        }

        // ●ユーザ情報の都道府県(users.state_id)
        if($paramsPost['state_id'] != 0) {
            $sql .= "AND ";
            $sql .= "      u1.state_id          =       :state_id ";
        }

        return $this->formatHalfWidthSpace($sql);

    }

    // あとで下記は削除　はじめユニオンしてデータを取得しようとした
    // 下記SQLの結果は同じユーザ情報が複数行取得出来てしまう。
    // そうするとページングが難しくなりそうだったので上記のSQLを使用することとした（selectUsersInfoSql）
    private function selectUsersInfoSql_old01() {
        $sql = "";
        $sql .= "SELECT * FROM ";
        $sql .= "( ";
        $sql .= "   ( ";
        $sql .= "    SELECT ";

        // ■■■　各テーブルから取得する値　その１（ユーザ、都道府県、担当パート）　■■■
        // ユーザ
        $sql .= "         u1.id AS u1_id ";
        $sql .= "       , u1.nickname AS u1_nickname ";
        $sql .= "       , u1.gender AS u1_gender ";
        $sql .= "       , u1.age AS u1_age ";
        $sql .= "       , u1.state_id AS u1_state_id ";
        $sql .= "       , u1.self_introduction AS u1_self_introduction ";
        $sql .= "       , u1.email AS u1_email ";
        $sql .= "       , u1.password AS u1_password ";
        $sql .= "       , u1.thumbnail_path AS u1_thumbnail_path ";
        $sql .= "       , u1.created_at AS u1_created_at ";
        $sql .= "       , u1.updated_at AS u1_updated_at ";
        $sql .= "       , u1.del_flg AS u1_del_flg ";
        
        // 都道府県
        $sql .= "       , ms1.id AS ms1_id ";
        $sql .= "       , ms1.name AS ms1_name ";
        
        // 担当パート
        $sql .= "       , p1.id AS p1_id ";
        $sql .= "       , p1.user_id AS p1_user_id ";
        $sql .= "       , p1.part_id AS p1_part_id ";
        $sql .= "       , mp1.id AS mp1_id ";
        $sql .= "       , mp1.part AS mp1_part ";
        
        // 業務領域（この値は空とする）
        $sql .= "       , '' AS w1_id ";
        $sql .= "       , '' AS w1_user_id ";
        $sql .= "       , '' AS w1_work_id ";
        $sql .= "       , '' AS mw1_id ";
        $sql .= "       , '' AS mw1_work ";

        $sql .= "    FROM ";

        // ■■■　各テーブル　■■■
        // ユーザ
        $sql .= "         users AS u1 ";

        // 都道府県マスタ
        $sql .= "    LEFT OUTER JOIN ";
        $sql .= "         state_mst AS ms1 ";
        $sql .= "    ON ";
        $sql .= "         u1.state_id = ms1.id ";
        
        // 担当パート
        $sql .= "    INNER JOIN ";
        $sql .= "         part AS p1 ";
        $sql .= "    ON ";
        $sql .= "         p1.user_id = u1.id ";
        
        // パートマスタ
        $sql .= "    INNER JOIN ";
        $sql .= "         part_mst AS mp1 ";
        $sql .= "    ON ";
        $sql .= "         p1.id = mp1.id ";

        // ★★★★★★★★★★★★★★★★★★★★★★★★WHERE句（担当パートで条件を絞り込む）
        $sql .= "    WHERE mp1.id IN (3) ";
        $sql .= "   ) ";
        
        $sql .= "   UNION ";
        
        $sql .= "   ( ";
        $sql .= "    SELECT ";

        // ■■■　各テーブルから取得する値　その２（ユーザ、都道府県、業務領域）　■■■
        // ユーザ
        $sql .= "         u1.id AS u1_id ";
        $sql .= "       , u1.nickname AS u1_nickname ";
        $sql .= "       , u1.gender AS u1_gender ";
        $sql .= "       , u1.age AS u1_age ";
        $sql .= "       , u1.state_id AS u1_state_id ";
        $sql .= "       , u1.self_introduction AS u1_self_introduction ";
        $sql .= "       , u1.email AS u1_email ";
        $sql .= "       , u1.password AS u1_password ";
        $sql .= "       , u1.thumbnail_path AS u1_thumbnail_path ";
        $sql .= "       , u1.created_at AS u1_created_at ";
        $sql .= "       , u1.updated_at AS u1_updated_at ";
        $sql .= "       , u1.del_flg AS u1_del_flg ";
        
        // 都道府県
        $sql .= "       , ms1.id AS ms1_id ";
        $sql .= "       , ms1.name AS ms1_name ";
        
        // 担当パート（この値は空とする）
        $sql .= "       , '' AS p1_id ";
        $sql .= "       , '' AS p1_user_id ";
        $sql .= "       , '' AS p1_part_id ";
        $sql .= "       , '' AS mp1_id ";
        $sql .= "       , '' AS mp1_part ";
       
        // 業務領域
        $sql .= "       , w1.id AS w1_id ";
        $sql .= "       , w1.user_id AS w1_user_id ";
        $sql .= "       , w1.work_id AS w1_work_id ";
        $sql .= "       , mw1.id AS mw1_id ";
        $sql .= "       , mw1.work AS mw1_work ";

        // ■■■　各テーブル　■■■
        $sql .= "    FROM ";

        // ユーザ
        $sql .= "         users AS u1 ";

        // 都道府県マスタ
        $sql .= "    LEFT OUTER JOIN ";
        $sql .= "         state_mst AS ms1 ";
        $sql .= "    ON ";
        $sql .= "         u1.state_id = ms1.id ";

        // 業務領域
        $sql .= "    INNER JOIN ";
        $sql .= "         work AS w1 ";
        $sql .= "    ON ";
        $sql .= "         w1.user_id = u1.id ";

        // 業務領域マスタ
        $sql .= "    INNER JOIN ";
        $sql .= "         work_mst AS mw1 ";
        $sql .= "    ON ";
        $sql .= "         w1.id = mw1.id ";

        // ★★★★★★★★★★★★★★★★★★★★★★★★WHERE句（業務領域で条件を絞り込む）
        $sql .= "    WHERE mw1.id IN (1) ";
        $sql .= "   ) ";
        $sql .= ") users_info ";

        // ★★★★★★★★★★★★★★★★★★★★★★★★WHERE句（その他条件で絞り込む）
        $sql .= "WHERE ";
        $sql .= "   u1_gender = 1 "; // ★WHERE句（性別）
        $sql .= "AND ";
        $sql .= "   u1_age = 20 "; // ★WHERE句（年代）
        $sql .= "AND ";
        $sql .= "   u1_state_id = 1 "; // ★WHERE句（都道府県）
        

        // 並び順をユーザID順とする
        $sql .= "ORDER BY ";
        $sql .= "   u1_id ";
        
        return $this->formatHalfWidthSpace($sql);
    }

}

?>