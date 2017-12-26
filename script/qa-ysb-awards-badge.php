<?php
if (!defined('QA_VERSION')) {
	require_once dirname(empty($_SERVER['SCRIPT_FILENAME']) ? __FILE__ : $_SERVER['SCRIPT_FILENAME']).'/../../../qa-include/qa-base.php';
}

require_once YSB_DIR . '/qa-ysb-badge.php';
require_once YSB_DIR . '/qa-ysb-badge-master.php';
require_once YSB_DIR . '/awards/qa-ysb-awards-base.php';
require_once YSB_DIR . '/awards/qa-ysb-awards-answer.php';
require_once YSB_DIR . '/awards/qa-ysb-awards-question.php';
require_once YSB_DIR . '/awards/qa-ysb-awards-blog.php';
require_once YSB_DIR . '/awards/qa-ysb-awards-action.php';

echo 'badge awards start...'.PHP_EOL;
$start = microtime(true);
try {
	$bm = new qa_ysb_badge_master();
	$awards = $bm->get_all_badge_name();

	foreach($awards as $name){
		$classname = 'qa_ysb_awards_' . $name;
		$awardsclass = new $classname();
		// すでに取得しているユーザー
		$exclude = qa_ysb_badge::already_have_badge_users($awardsclass->get_badgeid());

		$userids = $awardsclass->get_target_users_from_achievement($exclude);

		foreach($userids as $userid) {
			$awardsclass->save_badge_no_notification($userid);
		}
	}
} catch (Exception $e) {
	echo 'An error occurred.'.PHP_EOL;
	echo $e->getMessage();
	exit;
}
$end = microtime(true);
echo "processing time: " . ($end - $start) . "sec";
echo 'badge awards done!'.PHP_EOL;
