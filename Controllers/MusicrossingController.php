<?php 
  require_once(ROOT_PATH .'Models/User.php');
  class MusicrossingController {

    private $request; // リクエストパラメータ
    private $User;  // Userモデル

    public function __construct() {
      // リクエストパラメータの取得
      $this->request['get'] = $_GET;
      $this->request['post'] = $_POST;
      $this->User = new User();
    }


    public function registUser() {
        $results = $this->User->insert();
        return $results;
    }
    public function updateUser() {
        $result = $this->User->update();
        return $result;
    }


    public function signup() {
      $part = $this->User->partMstAll();
      $work = $this->User->workMstAll();
      $state = $this->User->stateMstAll();
      $params = ['part' => $part, 'work' => $work, 'state' => $state];
      return $params;
    }
    

    public function getUsersInfo() {
        $usersInfo = $this->User->getUsersInfo();
        return $usersInfo;
    }

    public function index() {
      $users = $this->User->userAll();
      $parts = $this->User->partAll();
      $part_name = $this->User->partMstAll();
      $works = $this->User->workAll();
      $work_name = $this->User->workMstAll();
      $state_name = $this->User->stateMstAll();
      $params = ['users' => $users,
                 'parts' => $parts,
                 'part_name' => $part_name,
                 'works' => $works,
                 'work_name' => $work_name,
                 'state_name' => $state_name,
                ];
      return $params;
    }

    public function login_confirm() {
      $this->request['post']['password'] = md5($this->request['post']['password']);
      $user = $this->User->loginUser($this->request['post']['email'], $this->request['post']['password']);
      $params = ['user' => $user];
      return $params;
    }

    public function profile($user_id) {
      $user = $this->User->findByUser($user_id);
      $part = $this->User->findByPart($user_id);
      $parts = $this->User->partMstAll();
      $work = $this->User->findByWork($user_id);
      $works = $this->User->workMstAll();
      $state = $this->User->stateMstAll();
      $params = ['user' => $user,
                 'part' => $part,
                 'parts' => $parts,
                 'work' => $work,
                 'works' => $works,
                 'state' => $state
                ];
      return $params;
    }

    public function userprofile() {
        $user = $this->User->findByUser($this->request['get']['id']);
        $part = $this->User->findByPart($this->request['get']['id']);
        $parts = $this->User->partMstAll();
        $work = $this->User->findByWork($this->request['get']['id']);
        $works = $this->User->workMstAll();
        $state = $this->User->stateMstAll();
        $params = ['user' => $user,
                   'part' => $part,
                   'parts' => $parts,
                   'work' => $work,
                   'works' => $works,
                   'state' => $state
                  ];
        return $params;
      }


      public function exchange_all() {
        $exchanges = $this->User->exchangeAll($this->request['get']['h_id'], $this->request['get']['g_id']);
        $user = $this->User->findByUser($this->request['get']['g_id']);
        $users = $this->User->groupUser($this->request['get']['h_id'], $this->request['get']['g_id']);
        $params = ['exchanges' => $exchanges, 'user' => $user, 'users' => $users];
        return $params;
      }

      public function exchange_create() {
        $this->request['post']['body'] = nl2br($this->request['post']['body']);
        $this->User->exchangeCreate($this->request['post']['host_user_id'], $this->request['post']['guest_user_id'], $this->request['post']['body_host_id'], $this->request['post']['group_name'], $this->request['post']['body']);
      }

      public function exchange() {
        $exchange_users = $this->User->exchangeUserAll($this->request['get']['id']);
        $users = $this->User->userAll();
        $params = ['exchange_users' => $exchange_users, 'users' => $users];
        return $params;
      }



    // 新規登録
    public function complete() {
        //$results = $this->User->insert();

    }

  }
?>