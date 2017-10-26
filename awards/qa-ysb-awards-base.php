<?php
/**
 * それぞれのAwardの基底クラス。
 *
 * @var [type]
 */
abstract class qa_ysb_awards_base
{

    const TABLE_NAME = '^ysb_badges';
    protected $userid;

    /**
     * badgeidを返す
     * @var [type]
     */
    abstract public function get_badgeid();

    /**
     * バッジの取得対象かチェック
     */
    abstract public function check_award_badge($userid, $params);

    /**
     * イベント発生時に対象のuseridを配列で取得
     */
    abstract public function get_award_target($event, $post_userid, $params);

    /**
     * バッジを授与する
     *
     * @param  ターゲットのUseridの配列
     * @return バッジを授与されたUseridの配列
     */
    public function award($userids)
    {
        $awarded_users = array();
        foreach($userids as $userid) {
            $awarded_users[] = array('userid' => $userid, 'badgeid' =>  $this->get_badgeid());
            $this->save_badge($userid);
        }
        return $awarded_users;
    }

    /**
     * イベントの発生時にバッジを授与
     * @return [type] [description]
     */
    public function awards_by_event($event, $post_userid, $params)
    {
        $users = $this->get_award_target($event, $post_userid, $params);
        return $this->award($users);
    }


    private function save_badge($userid)
    {
        $badge = new qa_ysb_badge($this->get_badgeid());
        if(!$badge->has_badge($userid)) {
            $badge->add_badge($userid);
        }
        $badge = null;
    }
}