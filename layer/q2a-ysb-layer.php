<?php
class qa_html_theme_layer extends qa_html_theme_base
{
  public function main()
  {
    if($this->template == 'badges'){
        $html = file_get_contents(YSB_DIR . '/html/badges.html');
        $this->output($html);

    } else {
        parent::main();
    }
  }
}
