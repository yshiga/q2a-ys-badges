<?php
/*
	Plugin Name: Badge
	Plugin URI: https://github.com/yshiga/q2a-ys-badges
	Plugin Description: provide simple badge functions
	Plugin Version: 1.0.0
	Plugin Date: 2017-8-9
	Plugin Author: yshiga
	Plugin Author URI: https://38qa.net/
	Plugin License: GPLv2
	Plugin Minimum Question2Answer Version: 1.5
	Plugin Update Check URI:
*/

if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
	header('Location: ../../');
	exit;
}

@define( YSB_DIR, dirname( __FILE__ ) );

qa_register_plugin_module('event', 'install/q2a-ysb-install.php', 'q2a_ysb_install', 'YSB Install');
qa_register_plugin_module('event', 'event/q2a-ysb-event.php', 'q2a_ysb_event', 'YSB Event');


class qa_ysb_const {

	const BADGES = array(
		array(
			'badgeid' => 10001,
			'actionid' => 101,
			'count' => array(1, 5, 10)
		),
		array(
			'badgeid' => 10002,
			'actionid' => 102,
			'count' => array(1, 20, 50)
		),
		array(
			'badgeid' => 10003,
			'actionid' => 103,
			'count' => array(1, 3, 10)
		),
		array(
			'badgeid' => 10004,
			'actionid' => 104,
			'count' => array(1, 5, 10)
		),
		array(
			'badgeid' => 10005,
			'actionid' => 104,
			'count' => array(1, 10, 20)
		),
	);

	const ACTIONS = array(
		101, // 回答に対する支持が一定数以上付与される
		102, // 回答する
		103, // 質問投稿の直後に回答する。
		104, // 一定期間回答がつかない質問に回答する
		105, // 文章量多く回答する
	);
}
