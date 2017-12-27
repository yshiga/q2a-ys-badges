<?php
class qa_ysb_badge_ranking
{
    const TABLE_NAME = '^ysb_badge_ranking';
    const QUESTION_BADGEID = 1001;
    const ANSWER_BADGEID = 1002;
    const BLOG_BADGEID = 1003;

    /*
     * 月間ランキングデータを作成する
     */
    public static function create_monthly_ranking($yearmonth)
    {
        $quserids = self::get_users_for_ranking($yearmonth, 'Q');
        // var_export($quserids);
        // echo PHP_EOL;
        foreach ($quserids as $userid) {
            self::award_ranking_badge($userid, self::QUESTION_BADGEID, $yearmonth, 0);
        }
        $auserids = self::get_users_for_ranking($yearmonth, 'A');
        foreach ($auserids as $userid) {
            self::award_ranking_badge($userid, self::ANSWER_BADGEID, $yearmonth, 0);
        }
        $buserids = self::get_users_for_ranking($yearmonth, 'B');
        foreach ($buserids as $userid) {
            self::award_ranking_badge($userid, self::BLOG_BADGEID, $yearmonth, 0);
        }
    }

    /**
     * ランキングバッジ対象ユーザーの取得
     * 最多投稿数が複数名になる場合もある
     */
    private static function get_users_for_ranking($yearmonth, $type)
    {
        if ($type == 'B') {
            $table = '^blogs';
        } else {
            $table = '^posts';
        }
        $sql = 'SELECT userid';
        $sql.= ' FROM (';
        $sql.= ' SELECT COUNT(userid) cnt, userid';
        $sql.= ' FROM '.$table;
        $sql.= ' WHERE TYPE = $';
        $sql.= " AND DATE_FORMAT(created, '%Y-%m') = $";
        $sql.= ' GROUP BY userid';
        $sql.= ' ) r';
        $sql.= ' WHERE cnt = ';
        $sql.= ' (';
        $sql.= ' SELECT COUNT(userid) cnt';
        $sql.= ' FROM '.$table;
        $sql.= ' WHERE TYPE = $';
        $sql.= " AND DATE_FORMAT(created, '%Y-%m') = $";
        $sql.= ' GROUP BY userid';
        $sql.= ' ORDER BY cnt DESC';
        $sql.= ' LIMIT 1';
        $sql.= ')';
        return qa_db_read_all_values(qa_db_query_sub($sql, $type, $yearmonth, $type, $yearmonth));
    }

    /**
     * ランキングバッジ授与
     */
    private static function award_ranking_badge($userid, $badgeid, $yearmonth, $show_flag)
    {
        if (!self::exists_ranking($userid, $badgeid, $yearmonth)) {
            qa_db_query_sub(
                'INSERT INTO ' . self::TABLE_NAME .
                ' ( userid, badgeid, award_date, show_flag, created, updated ) '.
                ' VALUES (#, #, $, #, NOW(), NOW())',
                $userid, $badgeid, $yearmonth, $show_flag
            );
            error_log('badge was added, badgeid:' . $badgeid. ', userid:' . $userid);
        }
    }

    /**
     * すでにランキングバッジを取得しているかどうか？
     */
    private static function exists_ranking($userid, $badgeid, $yearmonth)
    {
        $sql = 'SELECT COUNT(*)';
        $sql.= " FROM " . self::TABLE_NAME;
        $sql.= ' WHERE userid = #';
        $sql.= ' AND badgeid = #';
        $sql.= ' AND award_date = #';
        $count = qa_db_read_one_value(qa_db_query_sub($sql, $userid, $badgeid, $yearmonth));
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * useridでランキングバッジを取得する
     */
    public static function find_by_userid($userid)
    {
        $sql = 'SELECT badgeid, award_date';
        $sql.= ' FROM '. self::TABLE_NAME;
        $sql.= ' WHERE userid = #';
        $sql.= ' ORDER BY award_date';
        return qa_db_read_all_assoc(qa_db_query_sub($sql, $userid));
    }

    /*
     * useridでまだダイアログを表示していないバッジを取得
     */
    public static function find_by_not_noticed_badges($userid)
    {
        $sql = 'SELECT badgeid';
        $sql .= ' FROM ' . self::TABLE_NAME;
        $sql .= ' WHERE userid = # AND show_flag = 0';
        $sql .= ' ORDER BY badgeid';
        return qa_db_read_all_assoc(qa_db_query_sub($sql, $userid));
    }

    /**
     * badgeidからバッジ名を取得して返す
     */
    public static function get_badge_name($id)
    {
        $date = self::get_award_date($id);
        $dates = explode('-', $date);
        $name = qa_lang('ysb/badge_head_'.$id);
        return strtr($name, array(
            '^year' => $dates[0],
            '^month' => $dates[1]
        ));
    }

    public static function get_award_date($id)
    {
        $sql = 'SELECT award_date';
        $sql.= ' FROM '. self::TABLE_NAME;
        $sql.= ' WHERE badgeid = #';
        $res = qa_db_read_one_value(qa_db_query_sub($sql, $id));
        return $res;
    }

    public static function update_show_flag($userid, $badgeid)
    {
        $sql = 'UPDATE '.self::TABLE_NAME;
        $sql .= ' SET show_flag = #, updated = NOW()';
        $sql .= ' WHERE badgeid = # AND userid = #';
        qa_db_query_sub($sql, 1, $badgeid, $userid);
    }

}
