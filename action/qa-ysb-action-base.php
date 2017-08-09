<?php

/**
 * それぞれのアクションの基底クラス。
 *
 * @var [type]
 */
abstract class qa_ysb_action_base {

  const TABLE_NAME = '^ysb_actions';

  protected $userid;
  protected $count;

  /**
   * 現在の投稿テーブルの情報から、actionを1から計算し直す
   *
   * @param  ターゲットのUseridの配列
   * @return アクションの数が変動したUseridの配列
   */
  public function reculc($userids){
    $incremented_users = array();

    foreach($userids as $userid) {
      $reculc_count = $this->get_reculc_count($userid);
      $current_count = $this->get_current_count($userid);

      if($reculc_count > $current_count) {
        $incremented_users[] = array('userid' => $userid, 'actionid' =>  $this->get_actionid(), 'count' => $reculc_count);
        $this->save($userid, $reculc_count);
        error_log('update action count. userid:' . $userid);
      } else {
        error_log('no update action count. userid:' . $userid);
      }
    }

    return $incremented_users;
  }

  /**
   * イベントの発生時にカウントを増加させる
   * @return [type] [description]
   */
  public function increment_by_event($event, $params){
    $users = $this->get_increment_target($event, $params);
    return $this->reculc($users);

  }

  /**
   * アクションの回数を返す。
   * @return [type] [description]
   */
  private function get_current_count($userid) {
    $sql = 'SELECT count FROM ' . self::TABLE_NAME  . ' WHERE actionid=# AND userid=#';
		$result = qa_db_read_one_value(qa_db_query_sub($sql, $this->get_actionid(), $userid), true);
    if($result === null) {
      $result = 0;
    }
    return $result;
  }

  private function has_record($userid){
    $sql = 'SELECT count(*) FROM ' . self::TABLE_NAME  . ' WHERE actionid=# AND userid=#';
		$result = qa_db_read_one_value(qa_db_query_sub($sql, $this->get_actionid(), $userid), true);

    if($result == 0) {
      return false;
    }
    return true;
  }

  private function save($userid, $count){

    if(!$this->has_record($userid)) {
      echo 'insert';
      qa_db_query_sub(
        'INSERT INTO ' . self::TABLE_NAME .
        ' (actionid, userid, count, updated) '.
        'VALUES (#, #, #, NOW())',
        $this->get_actionid(), $userid, $count
      );

    } else {
      echo 'update';
      qa_db_query_sub(
        'UPDATE ' . self::TABLE_NAME .
        ' SET count=# '.
        'WHERE actionid=# AND userid=#',
        $count, $this->get_actionid(), $userid
      );
    }

  }

  /**
   * actionidを返す
   * @var [type]
   */
  abstract public function get_actionid();

  /**
   * テーブルでの再計算用のSQLを返す
   */
  abstract public function get_reculc_count($userid);

  /**
   * イベント発生時に再計算しなおす対象のuseridを配列で取得
   */
  abstract public function get_increment_target($event, $params);

}
