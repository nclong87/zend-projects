<?php

namespace Site;
use Core\DateUtils;

class HaiVlVideo extends \Site\Base {

    protected static $_instance = null;

    /**
     * 
     * @return \Site\HaiVlVideo
     */
    public static function getInstance() {
        if (!empty(self::$_instance)) {
            return self::$_instance;
        }
        self::$_instance = new \Site\HaiVlVideo();
        return self::$_instance;
    }
    
    protected $fetched_url_id;
    public function __construct() {
        parent::__construct();
        $this->_contentURL->initCurl();
    }
    
    public function process($data) {
        $this->_log->log(array(__CLASS__,__FUNCTION__,$data));
        parent::process($data);
        $this->fetched_url_id = $data['fetched_url_id'];
        $doc = $this->getDocument();
        if($doc == null) {
            return;
        }
        if($doc['.videoDetails']->length() > 0) {
            $title = trim($data['title']);
            $embed_video = $doc['.videoDetails .video iframe']->htmlOuter();
            $commentsURL = $doc['.fb-comments']->get(0)->getAttribute('data-href');
            $data = array('type' => 'video', 'title' => $title, 'caption' => $title,'embed' => $embed_video,'tags' => $commentsURL);
            $this->_log->log(array(__CLASS__,__FUNCTION__,'post',$data));
            $this->tumblClient->createPost($this->tumblBlogName, $data);
            $data['fetched_url_id'] = $this->fetched_url_id;
            $data['create_time'] = DateUtils::getCurrentDateSQL();
            \Db\Post::getInstance()->insert($data);
            $youtubeLink = \Core\Utils::getYoutubeVideoLinkFromIframe($embed_video);
            if($youtubeLink != '') {
                \Db\Post_Nhamvl::getInstance()->insert(array(
                    'type' => 'video',
                    'caption' => $title,
                    'link' => $youtubeLink,
                    'source_url' => $commentsURL,
                    'account_id' => ACCOUNT_HAIVL,
                    'status' => 1
                ));
            }
        }
        
        //echo 'Im HaiVlPhoto!' . PHP_EOL;
    }

}
