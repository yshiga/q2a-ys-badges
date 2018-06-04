<?php

require_once YSB_DIR.'/qa-ysb-badge.php';
require_once YSB_DIR.'/qa-ysb-badge-ranking.php';
require_once YSB_DIR.'/util/qa-ysb-html-builder.php';

class qa_html_theme_layer extends qa_html_theme_base
{
    public function main_parts($content)
    {
        if($this->template == 'user-badge'){
            $badges = $content['badges'];
            $ranking = $content['ranking'];
            qa_ysb_html_builder::output_user_badge($badges, $ranking);
        } else {
            parent::main_parts($content);
        }
    }

    public function notices()
    {
        if (qa_is_logged_in()) {
            $userid = qa_get_logged_in_userid();
            $badges = qa_ysb_badge::find_by_not_noticed_badges($userid);
            $ranking_badges = qa_ysb_badge_ranking::find_by_not_noticed_badges($userid);
            $badges = array_merge($badges, $ranking_badges);
            // $badgeids = array_column($badges, 'badgeid');
            if(count($badges) > 0) {
                qa_ysb_html_builder::output_badge_dialog($badges);
                $this->update_badges_flag($badges);
            }
        }
        parent::notices();
    }

    /*
     * バッジのshow_flag を 1 にする(ダイアログ表示済み)
     */
    private function update_badges_flag($badges)
    {
        $userid = qa_get_logged_in_userid();
        foreach($badges as $badge) {
            if($badge['badgeid'] > 1000) {
                qa_ysb_badge_ranking::update_show_flag($userid, $badge['id']);
            } else {
                $badge = new qa_ysb_badge($badge['badgeid']);
                $badge->set_show_flag(1);
                $badge->update_badge($userid);
                $badge = null;
            }
        }
    }
}
