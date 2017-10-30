<?php

/**
 * 質問系のバッジ付与のベースクラス
 */
abstract class qa_ysb_awards_question_base extends qa_ysb_awards_base
{

    public function get_award_target($event, $post_userid, $params)
    {
        if($event == 'q_post' && $this->check_award_badge($post_userid, $params)){
            return array($post_userid);
        }
        return array();
    }

    public function check_award_badge($userid, $params)
    {
        return true;
    }
}

/*
 * 質問者
 * 質問を投稿する
 */
class qa_ysb_awards_questioner extends qa_ysb_awards_question_base
{
    public function get_badgeid()
    {
        return 201;
    }

}

/*
 * 人気の質問
 * 質問にいいね！が3つ以上つく
 */
class qa_ysb_awards_good_question extends qa_ysb_awards_question_base
{
    const UPVOTE_THRESHOLD = 3;

    public function get_badgeid()
    {
        return 202;
    }

    public function get_award_target($event, $post_userid, $params)
    {
        if ($event == 'q_vote_up' && $this->check_award_badge($post_userid, $params)) {
            return array($params['userid']);
        }
        return array();
    }

    public function check_award_badge($userid, $params)
    {
        $sql = 'SELECT count(*)';
        $sql .= ' FROM ^posts WHERE upvotes >= #';
        $sql .= ' AND type="Q" AND postid = #';
        $count = qa_db_read_one_value(qa_db_query_sub($sql, self::UPVOTE_THRESHOLD, $params['postid']));

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
}

/*
 * 回答多数
 * 回答が5件以上寄せられる
 */
class qa_ysb_awards_with_many_answer extends qa_ysb_awards_question_base
{
    const ANSWER_THRESHOLD = 5;

    public function get_badgeid()
    {
        return 203;
    }

    public function get_award_target($event, $post_userid, $params)
    {
        if ($event == 'a_post' && $this->check_award_badge($post_userid, $params)) {
            return array($params['parent']['userid']);
        }
        return array();
    }

    public function check_award_badge($userid, $params)
    {
        $sql = 'SELECT count(*)';
        $sql .= ' FROM ^posts WHERE acount >= #';
        $sql .= ' AND type="Q" AND postid = #';
        $count = qa_db_read_one_value(qa_db_query_sub($sql, self::ANSWER_THRESHOLD, $params['parent']['postid']));

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
}

/*
 * 詳しい質問
 * 500文字以上の質問を投稿する
 */
class qa_ysb_awards_detail_question extends qa_ysb_awards_question_base
{
    const CHAR_LENGTH_THRESHOLD = 500;

    public function get_badgeid()
    {
        return 204;
    }

    public function check_award_badge($userid, $params)
    {
        $content = strip_tags($params['content']);
        if (mb_strlen($content, "UTF-8") >= self::CHAR_LENGTH_THRESHOLD) {
            return true;
        } else {
            return false;
        }
    }
}