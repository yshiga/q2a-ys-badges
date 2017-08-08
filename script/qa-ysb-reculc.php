<?php

if (!defined('QA_VERSION')) {
	require_once dirname(empty($_SERVER['SCRIPT_FILENAME']) ? __FILE__ : $_SERVER['SCRIPT_FILENAME']).'/../../../qa-include/qa-base.php';
}

require_once YSB_DIR . '/action/qa-ysb-action-base.php';
require_once YSB_DIR . '/action/qa-ysb-action-101.php';

for($i=0; $i < 2000; $i++) {
  $userid = $i;
  $tmp = new qa_ysb_action_101($userid);
  $tmp->reculc();

}
