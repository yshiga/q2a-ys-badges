<?php

require_once YSB_DIR.'/qa-ysb-badge-ranking.php';

class qa_ysb_html_builder {
    const IMAGE_BASE = 'qa-plugin/q2a-ys-badges/img/';

    /*
     * ユーザーバッジ一覧出力
     */
    public static function output_user_badge($badges, $ranking)
    {
        $imgurl = qa_opt('site_url').self::IMAGE_BASE.'badge_';
        $imgclass = 'no-badge-icon';
        $txtclass = 'mdl-typography--body-1';
        $txtclass2 = 'mdl-typography--body-1-color-contrast mdl-color-text--grey';
        $headclass = 'mdl-typography--display-1-color-contrast';
        $ranking_html = self::get_ranking_badges($ranking);
        include YSB_DIR . '/html/user-badge.html';
    }

    /*
     * バッジのダイアログ出力
     */
    public static function output_badge_dialog($badgeids)
    {
        $url = qa_opt('site_url').self::IMAGE_BASE;
        $handle = qa_get_logged_in_handle();
        $badgesurl = qa_path('user/'.$handle.'/badge',null,qa_opt('site_url'));
        $badgeobj = self::get_badges($badgeids);
        include YSB_DIR . '/html/badge-dialog.html';
    }

    /*
     * バッジ情報取得
     */
    private static function get_badges($ids)
    {
        $handle = qa_get_logged_in_handle();
        $badges = array();
        foreach($ids as $id) {
            $msgid = self::get_msgid($id);
            if ($id > 1000) {
                $badge_name = qa_ysb_badge_ranking::get_badge_name($id);
            } else {
                $badge_name = qa_lang('ysb/badge_head_'.$id);
            }
            $badges[] = array(
                'id' => $id,
                'title' => qa_lang_sub('ysb/badge_title', $badge_name),
                'img' => qa_opt('site_url').self::IMAGE_BASE.'badge_'.$id.'.svg',
                'msg' => qa_lang_sub($msgid, $handle)
            );
        }
        return $badges;
    }

    /*
     * ダイアログのメッセージID取得
     */
    private static function get_msgid($id)
    {
        $msgid = '';
        if ($id > 1000) {
            $msgid = 'ysb/badge_dialog_msg_ranking';
        } else {
            switch (substr($id,0,1)) {
                case '1':
                    $msgid = 'ysb/badge_dialog_msg_answer';
                    break;
                case '2':
                    $msgid = 'ysb/badge_dialog_msg_question';
                    break;
                case '3':
                    $msgid = 'ysb/badge_dialog_msg_blog';
                    break;
                case '4':
                    $msgid = 'ysb/badge_dialog_msg_action';
                    break;
            }
        }
        return $msgid;
    }

    /**
     * ランキング系バッジのHTML取得
     */
    private static function get_ranking_badges($ranking)
    {
        $html = '';
        if (!empty($ranking)) {
            $tmpl = file_get_contents(YSB_DIR . '/html/user-badge-ranking.html');
            $item_tmpl = file_get_contents(YSB_DIR.'/html/user-badge-item.html');
            $list = '';
            foreach($ranking as $id => $date) {
                $image_url=qa_opt('site_url').self::IMAGE_BASE.'badge_'.$id.'.svg';
                $dates = explode('-', $date);
                $param = array(
                    '^year' => $dates[0],
                    '^month' => $dates[1]
                );
                $badge_head = strtr(qa_lang('ysb/badge_head_'.$id), $param);
                $badge_body = strtr(qa_lang('ysb/badge_body_'.$id), $param);
                $list .= strtr($item_tmpl, array(
                    '^image_url' => $image_url,
                    '^badge_head' => $badge_head,
                    '^badge_body' => $badge_body
                ));
            }
            $html = strtr($tmpl, array(
                '^ranking_title' => qa_lang('ysb/section_ranking'),
                '^badge_list' => $list
            ));
        }
        return $html;
    }
}
