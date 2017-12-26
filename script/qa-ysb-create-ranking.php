<?php
if (!defined('QA_VERSION')) {
	require_once dirname(empty($_SERVER['SCRIPT_FILENAME']) ? __FILE__ : $_SERVER['SCRIPT_FILENAME']).'/../../../qa-include/qa-base.php';
}

require_once YSB_DIR . '/qa-ysb-badge-ranking.php';

echo 'badge ranking start...'.PHP_EOL;
$start = microtime(true);
try {
	if (!empty($argv[1]) && is_date($argv[1])) {
		$yearmonth = $argv[1];
	} else {
	$yearmonth = date('Y-m', strtotime('-1 Month'));
	}
	qa_ysb_badge_ranking::create_monthly_ranking($yearmonth);

} catch (Exception $e) {
	echo 'An error occurred.'.PHP_EOL;
	echo $e->getMessage();
	exit;
}
$end = microtime(true);
echo "processing time: " . ($end - $start) . "sec" .PHP_EOL;
echo 'badge ranking done!'.PHP_EOL;

function is_date($datestr)
{
	return true;
}