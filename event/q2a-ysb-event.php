<?php

require_once YSB_DIR . '/qa-ysb-badge.php';
require_once YSB_DIR . '/qa-ysb-badge-master.php';
require_once YSB_DIR . '/awards/qa-ysb-awards-base.php';
require_once YSB_DIR . '/awards/qa-ysb-awards-answer.php';

class q2a_ysb_event {

    function process_event($event, $post_userid, $post_handle, $cookieid, $params) {
        _log($event);

        $awards = array(
            'good_answer',
            'answer',
            'quick_answer'
        );

        foreach($awards as $name){
            $classname = 'qa_ysb_awards_' . $name;
            $awardsclass = new $classname();

            $users = $awardsclass->awards_by_event($event, $post_userid, $params);
        }
    }
}
