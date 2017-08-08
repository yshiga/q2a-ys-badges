<?php
class qa_ysb_badges {

  private $actions = array();

  /**
   * 保有しているバッチをすべて取得
   * @return [type] [description]
   */
  public function find_all(){

  }

  /**
   * 保有しているバッチをアクションで指定して取得
   * @return [type] [description]
   */
  private function find_by_action($action){

  }

  /**
   * アクションの状況から付与できるバッチを与える
   *
   * @param [type] $actionid [description]
   * @param [type] $count    [description]
   * @return バッチ付与なら付与したバッチのID, 付与なしならnullを返す
   */
  public function add_badge($actionid, $count){
    return 'test';

  }

}
