<?php

require_once YSB_DIR . '/qa-ysb-badge-master.php';

class qa_ysb_badge {

    const TABLE_NAME = '^ysb_badges';
    private $badgeid;
    private $show_flag;

    public function __construct($badgeid)
    {
        $this->badgeid = $badgeid;
        $this->show_flag = 0;
    }

    public function set_show_flag($value)
    {
        $this->show_flag = $value;
    }

    /**
    * 保有しているバッチをすべて取得
    * @return [type] [description]
    */
    public function find_by_userid($userid)
    {
        $sql = 'SELECT bt.badgeid, bt.userid, bt.show_flag, mt.name';
        $sql .= ' FROM  qa_ysb_badges AS bt LEFT JOIN qa_ysb_badge_master AS mt ON bt.badgeid = mt.badgeid ';
        $sql .= ' WHERE bt.userid=# ';
        return qa_db_read_all_assoc(qa_db_query_sub($sql, $userid));
    }

    /**
     * ユーザーにバッチを与える
     *
     * @param [type] $userid [バッジを授与するユーザーID]
     */
    public function add_badge($userid)
    {
        qa_db_query_sub(
            'INSERT INTO ' . self::TABLE_NAME .
            ' ( badgeid, userid, show_flag, created, updated ) '.
            ' VALUES (#, #, #, NOW(), NOW())',
            $this->badgeid, $userid, $this->show_flag 
        );
        error_log('badge was added, badgeid:' . $this->badgeid . ', userid:' . $userid);
    }
    
    /*
     * バッジを持っているかチェック
     */
    public function has_badge($userid)
    {
        $sql = 'SELECT count(*) FROM ' . self::TABLE_NAME  . ' WHERE badgeid=# AND userid=#';
        $result = qa_db_read_one_value(qa_db_query_sub($sql, $this->badgeid, $userid), true);

        if($result > 0) {
            return true;
        } else {
            return false;
        }
    }
}
