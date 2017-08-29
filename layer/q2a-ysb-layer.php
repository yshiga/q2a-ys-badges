<?php
class qa_html_theme_layer extends qa_html_theme_base
{
  public function main()
  {
    if($this->template == 'badges'){
        $html = file_get_contents(YSB_DIR . '/html/badges.html');
        $this->output($html);

/*
      foreach($this->content['custom']['badge_info'] as $badge){
        $this->output('・');
        $this->output(qa_lang('ysb/badge_name_' . $badge['badgeid']));
        $this->output('level: ' . $badge['level'] .  '/' . MAX_BADGE_LEVEL);
        if($badge['level'] < MAX_BADGE_LEVEL) {
          $this->output('次のバッチまで: ' . $badge['need_action_count'] . '回');
        }
        $this->output('<br>');
      }
      $html = '';

*/
    } else {
      parent::main();
    }
  }
}

/*
array(5) {
  ["badgeid"]=>
  string(5) "10001"
  ["level"]=>
  string(1) "2"
  ["next_action_count"]=>
  string(2) "10"
  ["need_action_count"]=>
  int(2)
  ["current_action_count"]=>
  string(1) "8"
}
*/
