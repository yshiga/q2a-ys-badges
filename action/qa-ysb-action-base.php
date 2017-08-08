<?php

/**
 * それぞれのアクションの基底クラス
 * @var [type]
 */
abstract class qa_ysb_action_base {

  const TABLE_NAME = '^ysb_actions';

  protected $userid;
  protected $count;

  public function __construct($userid) {
    $this->userid = $userid;
  }

  /**
   * 現在の投稿テーブルの情報から、actionを1から計算し直す
   * @return [type] [description]
   */
  public function reculc(){
    $this->count = $this->get_reculc_count();
    $this->save();
  }

  /**
   * イベントの発生時にカウントを増加させる
   * @return [type] [description]
   */
  public function increment_by_event($event){
    if(check_increment()){
      $count = $this->get_count();
      if($count === null) {
        $count = 0;
      }
      $count++;

      $this->save();
      return true;
    }
    return false;
  }

  /**
   * アクションの回数を返す。データ自体ない場合はnullが返る
   * @return [type] [description]
   */
  private function get_count() {
    $sql = 'SELECT count FROM ' . self::TABLE_NAME  . ' WHERE actionid=# AND userid=#';
		$result = qa_db_read_one_value(qa_db_query_sub($sql, $this->get_actionid(), $this->userid), true);
    return $result;
  }

  private function save(){

    if($this->get_count() === null) {
      echo 'insert';
      qa_db_query_sub(
        'INSERT INTO ' . self::TABLE_NAME .
        ' (actionid, userid, count, updated) '.
        'VALUES (#, #, #, NOW())',
        $this->get_actionid(), $this->userid, $this->count
      );

    } else {
      echo 'update';
      qa_db_query_sub(
        'UPDATE ' . self::TABLE_NAME .
        ' SET count=# '.
        'WHERE actionid=# AND userid=#',
        $this->count, $this->get_actionid(), $this->userid
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
  abstract public function get_reculc_count();

  /**
   * イベント発生時にアクションとしてカウントするか判定する。
   * 殖やす場合は、true, そうでなければfalseを返す
   */
  abstract public function check_increment($event, $params);

}
