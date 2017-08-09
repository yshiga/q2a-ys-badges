<?php

if (!defined('QA_VERSION')) {
	require_once dirname(empty($_SERVER['SCRIPT_FILENAME']) ? __FILE__ : $_SERVER['SCRIPT_FILENAME']).'/../../../qa-include/qa-base.php';
}

require_once YSB_DIR . '/qa-ysb-badge.php';
require_once YSB_DIR . '/qa-ysb-badge-master.php';
require_once YSB_DIR . '/action/qa-ysb-action-base.php';
require_once YSB_DIR . '/action/qa-ysb-action-1XX.php';

$badges = new qa_ysb_badges();


$sql = 'SELECT userid FROM ^users';
$users = qa_db_read_all_assoc(qa_db_query_sub($sql));

$userids = array_map(function($v){
	return $v['userid'];
}, $users);

foreach(qa_ysb_const::ACTIONS as $actionid){
	$clasname = 'qa_ysb_action_' . $actionid;
	$tmp = new $clasname();
	$imcrements = $tmp->reculc($userids);
	foreach($imcrements as $imcrement){
		$badges->add_badge($imcrement['userid'], $imcrement['actionid'], $imcrement['count']);
	}
}
