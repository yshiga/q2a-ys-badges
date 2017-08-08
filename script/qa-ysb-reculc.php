<?php

if (!defined('QA_VERSION')) {
	require_once dirname(empty($_SERVER['SCRIPT_FILENAME']) ? __FILE__ : $_SERVER['SCRIPT_FILENAME']).'/../../../qa-include/qa-base.php';
}

require_once YSB_DIR . '/action/qa-ysb-action-base.php';
require_once YSB_DIR . '/action/qa-ysb-action-1XX.php';


$userids = array();
for($i=0; $i < 2000; $i++) {
  $userid = $i;
	$userids[] = $userid;
}

foreach(qa_ysb_const::ACTIONS as $actionid){
	$clasname = 'qa_ysb_action_' . $actionid;
	$tmp = new $clasname();
	$tmp->reculc($userids);
}
