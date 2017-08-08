<?php

class qa_ysb_action_101 extends qa_ysb_action_base {

  const UPVOTE_THRESHOLD = 1;

  public function get_actionid(){
    return 101;
  }

  public function get_reculc_count(){
    $sql = 'SELECT count(*) FROM ^posts WHERE upvotes > # AND type="A" AND userid=#';
		return qa_db_read_one_value(qa_db_query_sub($sql, self::UPVOTE_THRESHOLD, $this->userid));
  }

  public function check_increment($event, $params){

  }

}
