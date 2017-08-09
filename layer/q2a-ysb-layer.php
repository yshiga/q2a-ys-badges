<?php
class qa_html_theme_layer extends qa_html_theme_base
{
  public function main()
  {
    if($this->template == 'badges'){
      $this->output($this->template);
    } else {
      parent::main();
    }
  }
}
