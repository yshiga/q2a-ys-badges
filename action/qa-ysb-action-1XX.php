<?php

/**
 * 100番台の回答系のアクションのベースクラス
 */
abstract class qa_ysb_action_1XX_base extends qa_ysb_action_base {

  public function get_increment_target($event, $post_userid, $params) {
    if($event == 'a_post'){
      return array($post_userid);
    }
    return array();
  }
}

class qa_ysb_action_101 extends qa_ysb_action_1XX_base {

  const UPVOTE_THRESHOLD = 1;

  public function get_actionid(){
    return 101;
  }

  public function get_reculc_count($userid){
    $sql = 'SELECT count(*) FROM ^posts WHERE upvotes > # AND type="A" AND userid=#';
		return qa_db_read_one_value(qa_db_query_sub($sql, self::UPVOTE_THRESHOLD, $userid));
  }

  public function get_increment_target($event, $post_userid, $params) {
    if($event == 'a_vote'){
      return array($params['userid']);
    }
    return array();
  }
}

class qa_ysb_action_102 extends qa_ysb_action_1XX_base {

  public function get_actionid(){
    return 102;
  }

  public function get_reculc_count($userid){
    $sql = 'SELECT count(*) FROM qa_posts WHERE type="A" AND userid= #';
		return qa_db_read_one_value(qa_db_query_sub($sql, $userid));
  }

}

class qa_ysb_action_103 extends qa_ysb_action_1XX_base {

  const MIN_THRESHOLD = 15;

  public function get_actionid(){
    return 103;
  }

  public function get_reculc_count($userid){
    $sql = 'SELECT count(*) FROM (';
    $sql .= 'SELECT qt.postid, TIMESTAMPDIFF(MINUTE, qt.created, at.created) AS time, at.userid ';
    $sql .= 'FROM qa_posts AS qt LEFT JOIN qa_posts AS at ON qt.postid = at.parentid ';
    $sql .= 'WHERE qt.type="Q" AND at.type="A" AND at.userid=# ';
    $sql .= 'HAVING time < #) AS tmp';
		return qa_db_read_one_value(qa_db_query_sub($sql, $userid, self::MIN_THRESHOLD));
  }
}

class qa_ysb_action_104 extends qa_ysb_action_1XX_base {

  const HOUR_THRESHOLD = 23;

  public function get_actionid(){
    return 104;
  }

  public function get_reculc_count($userid){
    $sql = 'SELECT count(*) FROM (';
    $sql .= 'SELECT min(TIMESTAMPDIFF(HOUR, qt.created, at.created)) as min_time, at.userid as userid ';
    $sql .= 'FROM qa_posts AS qt LEFT JOIN qa_posts AS at ON qt.postid = at.parentid ';
    $sql .= 'WHERE qt.type="Q" AND at.type="A" GROUP BY qt.postid having min_time > # ) AS tmp ';
    $sql .= 'WHERE tmp.userid = #';
		return qa_db_read_one_value(qa_db_query_sub($sql, self::HOUR_THRESHOLD, $userid));
  }
}


class qa_ysb_action_105 extends qa_ysb_action_1XX_base {

  const CHAR_LENGTH_THRESHOLD = 500;

  public function get_actionid(){
    return 105;
  }

  public function get_reculc_count($userid){
    $sql = 'SELECT count(*) FROM (';
    $sql .= ' SELECT CHAR_LENGTH(content) AS length, userid ';
    $sql .= ' FROM qa_posts WHERE type="A" AND userid = # ';
    $sql .= ' HAVING length > #) as tmp';
		return qa_db_read_one_value(qa_db_query_sub($sql, $userid, self::CHAR_LENGTH_THRESHOLD));
  }
}
