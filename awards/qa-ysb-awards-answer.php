<?php

/**
 * 回答系のバッジ付与のベースクラス
 */
abstract class qa_ysb_awards_answer_base extends qa_ysb_awards_base
{

    public function get_award_target($event, $post_userid, $params) {
        if($event == 'a_post' && $this->check_award_badge($post_userid, $params)){
            return array($post_userid);
        }
        return array();
    }

    public function check_award_badge($userid, $params){
        return true;
    }
}

class qa_ysb_awards_good_answer extends qa_ysb_awards_answer_base {

    const UPVOTE_THRESHOLD = 3;

    public function get_badgeid()
    {
        return 101;
    }

    public function check_award_badge($userid, $params)
    {
        _log('check good_answer');
        _log($params);

        $sql = 'SELECT count(*) ';
        $sql .= 'FROM ^posts WHERE upvotes > #';
        $sql .= ' AND type="A" AND postid=#';
        $count = qa_db_read_one_value(qa_db_query_sub($sql, self::UPVOTE_THRESHOLD, $params['postid']));
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_award_target($event, $post_userid, $params)
    {
        if($event == 'a_vote_up' && $this->check_award_badge($post_userid, $params)){
            return array($params['userid']);
        }
        return array();
    }
}

class qa_ysb_awards_answer extends qa_ysb_awards_answer_base
{
    public function get_badgeid(){
        return 102;
    }

}

class qa_ysb_awards_quick_answer extends qa_ysb_awards_answer_base
{

    const MIN_THRESHOLD = 15;

    public function get_badgeid()
    {
        return 103;
    }

    public function check_award_badge($userid, $params)
    {
        _log('checke quick answer');

        $before15min = new DateTime('-15 min');
        
        return (int)$before15min->format('U') < (int)$params['parent']['created'];
    }
}

// class qa_ysb_action_104 extends qa_ysb_action_1XX_base {

//   const HOUR_THRESHOLD = 23;

//   public function get_actionid(){
//     return 104;
//   }

//   public function get_recalc_count($userid){
//     $sql = 'SELECT count(*) FROM (';
//     $sql .= 'SELECT min(TIMESTAMPDIFF(HOUR, qt.created, at.created)) as min_time, at.userid as userid ';
//     $sql .= 'FROM qa_posts AS qt LEFT JOIN qa_posts AS at ON qt.postid = at.parentid ';
//     $sql .= 'WHERE qt.type="Q" AND at.type="A" GROUP BY qt.postid having min_time > # ) AS tmp ';
//     $sql .= 'WHERE tmp.userid = #';
// 		return qa_db_read_one_value(qa_db_query_sub($sql, self::HOUR_THRESHOLD, $userid));
//   }
// }


// class qa_ysb_action_105 extends qa_ysb_action_1XX_base {

//   const CHAR_LENGTH_THRESHOLD = 500;

//   public function get_actionid(){
//     return 105;
//   }

//   public function get_recalc_count($userid){
//     $sql = 'SELECT count(*) FROM (';
//     $sql .= ' SELECT CHAR_LENGTH(content) AS length, userid ';
//     $sql .= ' FROM qa_posts WHERE type="A" AND userid = # ';
//     $sql .= ' HAVING length > #) as tmp';
// 		return qa_db_read_one_value(qa_db_query_sub($sql, $userid, self::CHAR_LENGTH_THRESHOLD));
//   }
// }
