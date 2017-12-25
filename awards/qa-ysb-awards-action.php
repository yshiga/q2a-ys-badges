<?php

/**
 * アクション系のバッジ付与のベースクラス
 */
abstract class qa_ysb_awards_action_base extends qa_ysb_awards_base
{

    public function get_award_target($event, $post_userid, $params)
    {
        if($this->check_award_badge($post_userid, $params)){
            return array($post_userid);
        }
        return array();
    }
}

/*
 * 賛同
 * 回答を3回以上支持する
 */
class qa_ysb_awards_supporter extends qa_ysb_awards_action_base
{
    const UPVOTE_THRESHOLD = 3;

    public function get_badgeid()
    {
        return 401;
    }

    public function get_award_target($event, $post_userid, $params)
    {
        _log($post_userid);
        if ($event == 'a_vote_up' && $this->check_award_badge($post_userid, $params)) {
            return array($post_userid);
        }
        return array();
    }

    public function check_award_badge($userid, $params)
    {
        $sql = "SELECT count(*)";
        $sql.= " FROM ^uservotes uv";
        $sql.= " LEFT JOIN ^posts po";
        $sql.= " ON uv.postid = po.postid";
        $sql.= " WHERE uv.userid = #";
        $sql.= " AND uv.vote = 1";
        $sql.= " AND po.type = 'A'";
        $count = qa_db_read_one_value(qa_db_query_sub($sql, $userid));

        if ($count >= self::UPVOTE_THRESHOLD) {
            return true;
        } else {
            return false;
        }
    }

    public function get_target_users_from_achievement($exclude)
    {
        // $sql = 'SELECT DISTINCT userid';
        // $sql.= ' FROM ^blogs';
        // $sql.= ' WHERE upvotes >= #';
        // $sql.= ' AND type="B"';
        // $sql.= ' AND userid IS NOT NULL';
        // if (!empty($exclude)) {
        //     $sql.= qa_db_apply_sub(' AND userid NOT IN (#)', array($exclude));
        // }
        // $sql.= ' ORDER BY userid';
        // return qa_db_read_all_values(qa_db_query_sub($sql, self::UPVOTE_THRESHOLD));
    }
}