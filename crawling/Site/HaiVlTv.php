<?php

namespace Site;
use Core\DateUtils;
use Db\FetchedUrl;

class HaiVlTv extends \Site\Base {

    protected static $_instance = null;

    /**
     * 
     * @return \Site\HaiVlTv
     */
    public static function getInstance() {
        if (!empty(self::$_instance)) {
            return self::$_instance;
        }
        self::$_instance = new \Site\HaiVlTv();
        return self::$_instance;
    }

    public function __construct() {
        parent::__construct();
        $this->_contentURL->initCurl();
    }

    public function process($data) {
        $this->_log->log(array(__CLASS__,__FUNCTION__,$data));
        parent::process($data);
        $doc = $this->getDocument();
        if($doc == null) {
            return;
        }
        if($doc['.videoList']->length() > 0) { 
            foreach ($doc['.videoList div.videoListItem'] as $element) {
                $a = pq($element)->find('h2 > a')->get(0);
                $href = trim($a->getAttribute('href'));
                $href = $this->getFullUrl($href);
                if(!empty($href)) {
                    $this->_log->log(array(__CLASS__,__FUNCTION__,$href));
                    $row = FetchedUrl::getInstance()->query(array('url' => $href), true);
                    if($row == null) {
                        $fetched_url_id = FetchedUrl::getInstance()->insert(array(
                            'url' => $href,
                            'parent_url' => $this->_url,
                            'create_time' => DateUtils::getCurrentDateSQL()
                        ),true);
                        $this->_redis->rpush(KEY_REDIS_JOB_QUEUE, array(
                            'class' => 'HaiVlVideo',
                            'data' => array(
                                'url' => $href,
                                'fetched_url_id' => $fetched_url_id,
                                'title' => pq($element)->find('div.thumb img')->get(0)->getAttribute('alt')
                            )
                        ));
                    }
                }
            }
        }
        $this->_log->log(array(__CLASS__,__FUNCTION__,'end'));
    }

}
