<?php

require_once YSB_DIR . '/qa-ysb-badge.php';
require_once YSB_DIR . '/action/qa-ysb-action-base.php';
require_once YSB_DIR . '/action/qa-ysb-action-1XX.php';

class q2a_ysb_event {

  function process_event($event, $post_userid, $post_handle, $cookieid, $params) {
    error_log($event . ',' . $post_userid . ', params:' . print_r($params, true));

    $badges = new qa_ysb_badges();

    foreach(qa_ysb_const::ACTIONS as $actionid){
      $clasname = 'qa_ysb_action_' . $actionid;
      $tmp = new $clasname();

      // actionテーブルを更新
      $imcrements = $tmp->increment_by_event($event, $post_userid, $params);

      // actionの更新に基づいてバッチを更新
      foreach($imcrements as $imcrement) {
        $badges->add_badge($imcrement['userid'], $imcrement['actionid'], $imcrement['count']);
      }
    }
  }
}
