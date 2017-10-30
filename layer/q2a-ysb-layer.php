<?php
class qa_html_theme_layer extends qa_html_theme_base
{
    public function main()
    {
        if($this->template == 'badges'){
            $html = file_get_contents(YSB_DIR . '/html/badges.html');
            $this->output($html);
        } elseif($this->template == 'user-badge'){
            $tmpl = file_get_contents(YSB_DIR . '/html/user-badge.html');
            $class = 'mdl-typography--display-1-color-contrast';
            $class2 = 'mdl-typography--body-1-color-contrast mdl-color-text--grey';
            $params = array(
                '^url' => qa_opt('site_url').'qa-plugin/q2a-ys-badges/img/',
                '^img105' => $class,
                '^text105' => $class2,
            );
            $html = strtr($tmpl, $params);
            $this->output($html);
        } else {
            parent::main();
        }
    }
}
