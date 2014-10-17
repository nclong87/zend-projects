<?php

namespace Site;
use Core\DateUtils;

class ChatVlVideo extends \Site\Base {

    protected static $_instance = null;

    /**
     * 
     * @return \Site\ChatVlVideo
     */
    public static function getInstance() {
        if (!empty(self::$_instance)) {
            return self::$_instance;
        }
        self::$_instance = new \Site\ChatVlVideo();
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
        if($doc['#video-container']->length() > 0) {
            $title = trim($data['title']);
            $embed_video = $doc['#video-container iframe']->htmlOuter();
            $commentsURL = $this->_url;
            $data = array('type' => 'video', 'title' => $title, 'caption' => $title,'embed' => $embed_video,'tags' => $commentsURL);
            $this->_log->log(array(__CLASS__,__FUNCTION__,'post',$data));
            $this->tumblClient->createPost($this->tumblBlogName, $data);
            $data['fetched_url_id'] = $this->fetched_url_id;
            $data['create_time'] = DateUtils::getCurrentDateSQL();
            \Db\Post::getInstance()->insert($data);
            $youtubeLink = \Core\Utils::getYoutubeVideoLinkFromIframe($embed_video);
            if($youtubeLink != '') {
                $data_post_nhamvl = array(
                    'type' => 'video',
                    'caption' => $title,
                    'link' => $youtubeLink,
                    'source_url' => $commentsURL,
                    'account_id' => ACCOUNT_CHATVL,
                    'status' => 1
                );
                $this->_log->log(array(__CLASS__,__FUNCTION__,$data_post_nhamvl));
                \Db\Post_Nhamvl::getInstance()->insert($data_post_nhamvl);
            }
        }
        
        //echo 'Im HaiVlPhoto!' . PHP_EOL;
    }

}
