<?php
require_once YSB_DIR . '/qa-ysb-badge.php';
require_once YSB_DIR . '/qa-ysb-badge-master.php';

class qa_badge_page
{
    public $directory;
    public $urltoroot;

    public function load_module($directory, $urltoroot)
    {
        $this->directory=$directory;
        $this->urltoroot=$urltoroot;
    }

    public function suggest_requests() // for display in admin interface
    {
        return array(
                array(
                    'title' => qa_lang('ysb/page_title'),
                    'request' => 'badges',
                ),
            );
    }

    public function match_request($request)
    {
        if ($request=='badges') {
            return true;
        }
        return false;
    }
    public function process_request($request)
    {
        qa_set_template('badges');

        $qa_content=qa_content_prepare();
        $qa_content['title']=qa_lang('ysb/page_title');

        $userid = qa_get_logged_in_userid();

        // $badges_model = new qa_ysb_badges();
        // $badges_owns = $badges_model->find_by_userid($userid);

        // $tmp = array();
        // foreach($badges_owns as $badge) {
        //   $tmp[$badge['badgeid']] = $badge;
        // }
        // $badges_owns = $tmp;

        // $badge_info = array();
        // $badge_masters = qa_ysb_badge_master::find_all();
        // // 所有バッチの情報を生成する
        // foreach($badge_masters as $badge_master) {
        //   $level = 0;
        //   $badgeid =  $badge_master['badgeid'];

        //   if(!empty($badges_owns[$badgeid])) {
        //     $level = $badges_owns[$badgeid]['level'];
        //   }

        //   $next_count = -1;
        //   if($level < MAX_BADGE_LEVEL) {
        //     $next_count = $badge_master['action_level_' . ($level+1)];
        //   }

        //   $need_action_count = -1;
        //   if($level == MAX_BADGE_LEVEL)  {
        //     $need_action_count = 0;
        //   } else {
        //     $need_action_count = $next_count - $badges_owns[$badgeid]['count'];
        //   }

        //   $badge_info[] = array(
        //     'badgeid' => $badge_master['badgeid'],
        //     'level' => $level,
        //     'next_action_count' => $next_count,
        //     'need_action_count' => $need_action_count,
        //     'current_action_count' => $badges_owns[$badgeid]['count']
        //   );

        // }
        // $qa_content['custom']['badge_info'] = $badge_info;

        return $qa_content;
    }
};
