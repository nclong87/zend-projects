<?php
namespace Site;
use Core\Log;

abstract class Base {

    /**
     *
     * @var Log 
     */
    protected $_log;
    
    /**
     *
     * @var \Core\ContentURL 
     */
    protected $_contentURL;
    
    /**
     *
     * @var \Core\Redis
     */
    protected $_redis;
    protected $_url;
    protected $_baseUrl;
    protected $tumblClient;
    protected $tumblBlogName = 'nhamvcl.tumblr.com';

    public function __construct() {
        $this->_log = Log::getInstance();
        $this->_contentURL = \Core\ContentURL::getInstance();
        $this->_redis = \Core\Redis::getInstance();
        $this->tumblClient = new \Tumblr\API\Client('v7WqQsKTZ94DIP2fmGGN8T4G85qDZiu54LkhRcwN9Tyitlvtgz',
  'qgyPINUn6qGQc3bCXkoWSkrrMWYUegzQDL3NE4Ayk6g0ZkZ5mR',
  '5p7QAcMQt5sEGzjSX5C0H3nzAsPnXOK0pCJo3DtfFqD2aA7j06',
  'rrRbhUn7LurFkfbZjr1eleuzIQELa7nkGSaPQWMuBhsCJmPchx');
    }
    
    public function process($data) {
        $this->_url = $data['url'];
        $parts = parse_url($this->_url);
        $this->_log->log(array(__CLASS__,__FUNCTION__,$data['url'],$parts));
        $this->_baseUrl = $parts['scheme'] . '://'. $parts['host'];
    }
    
    protected function getFullUrl($url) {
        $host = parse_url($url,PHP_URL_HOST);
        if(!empty($host)) {
            return $url;
        }
        return $this->_baseUrl . $url;
    }
    
    protected function getDocument() {
        $content = $this->_contentURL->getContent($this->_url);
        $doc = null;
        if (!empty($content)) {
            $charset = mb_detect_encoding($content);
            if ($charset == 'UTF-8') {
                $doc = \phpQuery::newDocumentHTML($content);
            } else {
                $doc = \phpQuery::newDocumentHTML($content, 'UTF-8');
            }
        }
        return $doc;
    }
    
}
