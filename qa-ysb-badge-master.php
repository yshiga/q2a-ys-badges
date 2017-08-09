<?php
class qa_ysb_badge_master
{
    const TABLE_NAME = '^ysb_badge_master';

    public static function find_all()
    {
		    $sql = 'SELECT * FROM ' . self::TABLE_NAME;
        return qa_db_read_all_assoc(qa_db_query_sub($sql));
    }

    public function renew()
    {
        $badges = array(
          array(
            'badgeid' => 10001,
            'actionid' => 101,
            'count' => array(1, 5, 10)
          ),
          array(
            'badgeid' => 10002,
            'actionid' => 102,
            'count' => array(1, 20, 50)
          ),
          array(
            'badgeid' => 10003,
            'actionid' => 103,
            'count' => array(1, 3, 10)
          ),
          array(
            'badgeid' => 10004,
            'actionid' => 104,
            'count' => array(1, 5, 10)
          ),
          array(
            'badgeid' => 10005,
            'actionid' => 105,
            'count' => array(1, 10, 20)
          ),
        );

        qa_db_query_sub('DELETE FROM ' . self::TABLE_NAME);
        $sql = 'INSERT INTO ' . self::TABLE_NAME . ' VALUES (#, #, #, #, #);';
        foreach ($badges as $badge) {
            qa_db_query_sub(
              $sql,
              $badge['badgeid'],
              $badge['actionid'],
              $badge['count'][0],
              $badge['count'][1],
              $badge['count'][2]
            );
        }
    }


}
