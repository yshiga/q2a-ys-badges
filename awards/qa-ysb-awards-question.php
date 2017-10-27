<?php

/**
 * 質問系のバッジ付与のベースクラス
 */
abstract class qa_ysb_awards_question_base extends qa_ysb_awards_base
{

    public function get_award_target($event, $post_userid, $params) {
        if($event == 'q_post' && $this->check_award_badge($post_userid, $params)){
            return array($post_userid);
        }
        return array();
    }

    public function check_award_badge($userid, $params){
        return true;
    }
}

/*
 * 質問者
 * 質問を投稿する
 */
class qa_ysb_awards_questioner extends qa_ysb_awards_question_base
{
    public function get_badgeid(){
        return 201;
    }

}
