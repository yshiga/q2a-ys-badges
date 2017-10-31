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
}