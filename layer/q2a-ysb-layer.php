<?php

require_once YSB_DIR.'/util/qa-ysb-html-builder.php';

class qa_html_theme_layer extends qa_html_theme_base
{
    public function main()
    {
        if($this->template == 'badges'){
            $html = file_get_contents(YSB_DIR . '/html/badges.html');
            $this->output($html);
        } elseif($this->template == 'user-badge'){
            $badges = $this->content['badges'];
            qa_ysb_html_builder::output_user_badge($badges);
        } else {
            parent::main();
        }
    }
}
