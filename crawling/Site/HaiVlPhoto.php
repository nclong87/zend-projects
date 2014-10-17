<?php

namespace Site;
use Core\ImageUtils;
use Core\DateUtils;

class HaiVlPhoto extends \Site\Base {

    protected static $_instance = null;

    /**
     * 
     * @return \Site\HaiVlPhoto
     */
    public static function getInstance() {
        if (!empty(self::$_instance)) {
            return self::$_instance;
        }
        self::$_instance = new \Site\HaiVlPhoto();
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
        if($doc['.photoImg']->length() > 0) {
            $title = $doc['.photoInfo > h1']->html();
            $photo_files = array();
            $data_photo_files = array();
            $embed_video = '';
            
            //photos post
            foreach ($doc['.photoImg img'] as $index => $img) {
                $src = trim(pq($img)->get(0)->getAttribute('src'));
                $alt = trim(pq($img)->get(0)->getAttribute('alt'));
                if(!empty($alt)) {
                    $title = $alt;
                }
                $data_photo_files[] = $src;
                $fileName = '/tmp/haivlphoto'.$index.'.jpg';
                ImageUtils::saveImage($src, $fileName);
                $photo_files[] = $fileName;
            }
            $title = trim($title);
            
            //videos post
            if($doc['.photoImg iframe']->length() > 0) {
                $embed_video = $doc['.photoImg iframe']->htmlOuter();
            }
            $data = '';
            $post_nhamvl_data = '';
            $commentsURL = $doc['.fb-comments']->get(0)->getAttribute('data-href');
            if(!empty($photo_files)) {
                $data = array('type' => 'photo', 'title' => $title,'caption' => $title, 'link' => $commentsURL,'source' => '','data' => $photo_files,'tags' => $commentsURL);
                
            } else if (!empty ($embed_video)) {
                $data = array('type' => 'video', 'title' => $title, 'caption' => $title,'embed' => $embed_video,'tags' => $commentsURL);
                $youtubeLink = \Core\Utils::getYoutubeVideoLinkFromIframe($embed_video);
                if($youtubeLink != '') {
                    $post_nhamvl_data = array(
                        'type' => 'video',
                        'caption' => $title,
                        'link' => $youtubeLink,
                        'source_url' => $commentsURL,
                        'status' => 1
                    );
                }
            }
            if(!empty($data)) {
                $this->_log->log(array(__CLASS__,__FUNCTION__,'post',$data));
                $response = $this->tumblClient->createPost($this->tumblBlogName, $data);
                $post_id = isset($response->id)?$response->id:'';
                $data['data'] = json_encode($data_photo_files);
                $data['fetched_url_id'] = $this->fetched_url_id;
                $data['create_time'] = DateUtils::getCurrentDateSQL();
                \Db\Post::getInstance()->insert($data);
                if($data['type'] == 'photo' && $post_id != '') {
                    $retval = $this->tumblClient->getBlogPosts($this->tumblBlogName, array('id' => $post_id));
                    $photoUrl = '';
                    if(isset($retval->posts[0]->photos) && !empty($retval->posts[0]->photos)) {
                        foreach ($retval->posts[0]->photos as $photo) {
                            $org_sizes = $photo->alt_sizes[0];
                            $photoUrl = $org_sizes->url;
                            break;
                        }
                    }
                    if($photoUrl != '') {
                        $post_nhamvl_data = array(
                            'type' => 'image',
                            'caption' => $title,
                            'link' => $photoUrl,
                            'source_url' => $commentsURL,
                            'status' => 1
                        );
                    }
                }
                if($post_nhamvl_data != '') {
                    $post_nhamvl_data['account_id'] = ACCOUNT_HAIVL;
                    \Db\Post_Nhamvl::getInstance()->insert($post_nhamvl_data);
                }
            }
        }
        
        //echo 'Im HaiVlPhoto!' . PHP_EOL;
    }
    
}
