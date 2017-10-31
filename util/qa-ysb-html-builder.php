<?php

class qa_ysb_html_builder {

    public static function output_user_badge($badges)
    {
        $url = qa_opt('site_url').'qa-plugin/q2a-ys-badges/img/';
        $imgclass = 'mdl-typography--display-1-color-contrast';
        $txtclass = 'mdl-typography--body-1';
        $txtclass2 = 'mdl-typography--body-1-color-contrast mdl-color-text--grey';
        $headclass = 'mdl-typography--display-1-color-contrast';
        include YSB_DIR . '/html/user-badge.html';
    }

    public static function output_badge_dialog($badgeids)
    {
        $url = qa_opt('site_url').'qa-plugin/q2a-ys-badges/img/';
        $badgeobj = self::get_badges($badgeids);
        include YSB_DIR . '/html/badge-dialog.html';
    }

    private static function get_badges($ids)
    {
        $badges = array();
        foreach($ids as $id) {
            $badges[] = array(
                'id' => $id,
                'title' => qa_lang('ysb/badge_head_'.$id),
            );
        }
        return $badges;
    }
}