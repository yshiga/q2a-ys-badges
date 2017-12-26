<?php
class qa_ysb_badge_ranking
{
    const TABLE_NAME = '^ysb_badge_ranking';

    public static function create_monthly_ranking($yearmonth)
    {
        $quserids = self::get_users_for_ranking($yearmonth, 'Q');
        // var_export($quserids);
        // echo PHP_EOL;
        foreach ($quserids as $userid) {
            self::award_ranking_badge($userid, 501, $yearmonth, 0);
        }
        $auserids = self::get_users_for_ranking($yearmonth, 'A');
        foreach ($auserids as $userid) {
            self::award_ranking_badge($userid, 502, $yearmonth, 0);
        }
        $buserids = self::get_users_for_ranking($yearmonth, 'B');
        foreach ($buserids as $userid) {
            self::award_ranking_badge($userid, 503, $yearmonth, 0);
        }
    }

    public static function get_users_for_ranking($yearmonth, $type)
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

    public static function award_ranking_badge($userid, $badgeid, $yearmonth, $show_flag)
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

    public static function exists_ranking($userid, $badgeid, $yearmonth)
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

}
