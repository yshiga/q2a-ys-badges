<?php

class q2a_ysb_event {

  function process_event($event, $post_userid, $post_handle, $cookieid, $params) {
    error_log($event . ', params:' . print_r($params));
  }

}
