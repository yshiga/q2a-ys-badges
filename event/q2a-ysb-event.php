<?php

require_once YSB_DIR . '/action/qa-ysb-action-base.php';
require_once YSB_DIR . '/action/qa-ysb-action-1XX.php';

class q2a_ysb_event {

  function process_event($event, $post_userid, $post_handle, $cookieid, $params) {
    error_log($event . ', params:' . print_r($params, true));

    $tmp = new qa_ysb_action_101();
    $users = $tmp->increment_by_event($event, $params);

/*
    foreach($actions as $action_id) {
      $action_class_name = 'qa_ysb_action_' . $action_id;
      $tmp = new $action_class_name();
      $users = $tmp->increment_by_event($event, $params);

      // badgeの付与を行う
    }
*/
  }

}
