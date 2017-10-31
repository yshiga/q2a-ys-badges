<?php

require_once YSB_DIR.'/qa-ysb-badge.php';
require_once YSB_DIR.'/util/qa-ysb-html-builder.php';

class qa_html_theme_layer extends qa_html_theme_base
{
    public function main()
    {
        if($this->template == 'user-badge'){
            $badges = $this->content['badges'];
            qa_ysb_html_builder::output_user_badge($badges);
        } else {
            parent::main();
        }
    }

    public function body_footer()
    {
        parent::body_footer();
        if (qa_is_logged_in()) {
            $badges = qa_ysb_badge::find_by_not_noticed_badges(qa_get_logged_in_userid());
            $badgeids = array_column($badges, 'badgeid');
            if(count($badgeids) > 0) {
                qa_ysb_html_builder::output_badge_dialog($badgeids);
                // $this->update_badges_flag($badgeids);
            }
        }
    }

    private function update_badges_flag($badgeids)
    {
        $userid = qa_get_logged_in_userid();
        foreach($badgeids as $id) {
            // ここでフラグをたてる
            $badge = new qa_ysb_badge($id);
            $badge->set_show_flag(1);
            $badge->update_badge($userid);
        }
    }
}
