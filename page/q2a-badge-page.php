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

        return $qa_content;
    }
};
