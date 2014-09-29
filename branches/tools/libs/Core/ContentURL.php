<?php
namespace Core;
use Core\Encoding;
define('PATH_COOKIE', '/tmp');

class ContentURL {

    protected static $_instance = null;

    /**
     * 
     * @param type $params
     * @return \Core\ContentURL
     */
    public static function getInstance() {
        // Check instance
        if (empty(self::$_instance)) {
            self::$_instance = new \Core\ContentURL();
        }

        // Return instance
        return self::$_instance;
    }

    private $ch;

    /**
     * Init curl session
     *
     * $params = array('url' => '',
     * 'host' => '',
     * 'header' => '',
     * 'method' => '',
     * 'referer' => '',
     * 'cookie' => '',
     * 'post_fields' => '',
     * ['login' => '',]
     * ['password' => '',]
     * 'timeout' => 0
     * );
     */
    public function __destruct() {
        curl_close($this->ch);
    }

    public function initCurl($params = array()) {
        if (isset($params ['url'])) {
            $this->ch = curl_init($params ['url']);
        } else {
            $this->ch = curl_init();
        }
        if (isset($params ['return']) && $params ['return'] == 0) {
            curl_setopt($this->ch, CURLOPT_WRITEFUNCTION, 'do_nothing');
        } else {
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        }

        // $user_agent = 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)';

        if (!isset($params ['header']) || empty($params ['header'])) {
            $header = array(
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Encoding: gzip, deflate',
                'Accept-Language: en-US,en;q=0.5',
                'Connection: keep-alive',
                'DNT: 1',
                'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:19.0) Gecko/20100101 Firefox/19.0',
                'X-Requested-With:      XMLHttpRequest'
            );
        } else {
            $header = $params ['header'];
        }
        if (isset($params ['cookie'])) {
            $header [] = $params ['cookie'];
        }
        if (isset($params ['host']) && $params ['host']) {
            $header [] = "Host: " . $params ['host'];
        }

        // @curl_setopt ( $this -> ch , CURLOPT_VERBOSE , 1 );
        curl_setopt($this->ch, CURLOPT_HEADER, 1);
        if (isset($params ['proxy']) && !empty($params ['proxy'])) {
            curl_setopt($this->ch, CURLOPT_PROXY, $params ['proxy']);
        }
        if (isset($params ['method']) && $params ['method'] == "HEAD") {
            curl_setopt($this->ch, CURLOPT_NOBODY, 1);
        }
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $header);
        if (isset($params ['referer'])) {
            curl_setopt($this->ch, CURLOPT_REFERER, $params ['referer']);
        }
        // @curl_setopt ( $this -> ch , CURLOPT_USERAGENT, $user_agent);
        if (!file_exists(PATH_COOKIE) || !is_writable(PATH_COOKIE)) {
            echo 'Create cookie file...';
            $ourFileHandle = fopen(PATH_COOKIE, 'w') or die("can't open file");
            fclose($ourFileHandle);
        }
        if (!isset($params ['cookie'])) {
            curl_setopt($this->ch, CURLOPT_COOKIEFILE, PATH_COOKIE);
            curl_setopt($this->ch, CURLOPT_COOKIEJAR, PATH_COOKIE);
        }
        if (isset($params ['method']) && $params ['method'] == "POST") {
            curl_setopt($this->ch, CURLOPT_POST, true);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params ['post_fields']);
        }
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->ch, CURLOPT_ENCODING, "gzip");
        if (isset($params ['login']) & isset($params ['password'])) {
            curl_setopt($this->ch, CURLOPT_USERPWD, $params ['login'] . ':' . $params ['password']);
        }
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 60);
    }

    public function __construct() {
        //$this->ch = $this->initCurl($params);
    }

    /**
     * Make curl request
     *
     * @return array 'header','body','curl_error','http_code','last_url'
     */
    public function exec($return = true) {
        $response = curl_exec($this->ch);
        if ($return) {
            $cookie = '';
            $m = '';
            preg_match('/^Set-Cookie:\s*([^;]*)/mi', $response, $m);
            if (isset($m [1])) {
                parse_str($m [1], $cookie);
            }
            $error = curl_error($this->ch);
            $result = array(
                'header' => '',
                'body' => '',
                'curl_error' => '',
                'http_code' => '',
                'last_url' => ''
            );
            if ($error != "") {
                $result ['curl_error'] = $error;
                return $result;
            }

            $header_size = curl_getinfo($this->ch, CURLINFO_HEADER_SIZE);
            $result ['header'] = substr($response, 0, $header_size);
            $result ['body'] = substr($response, $header_size);
            $result ['http_code'] = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
            $result ['last_url'] = curl_getinfo($this->ch, CURLINFO_EFFECTIVE_URL);
            $result ['cookie'] = $cookie;
            // curl_close($this->ch);
            return $result;
        }
    }

    public function getContent($url) {
        $content = '';
        try {
            curl_setopt($this->ch, CURLOPT_URL, $url);
            /*
             * $params = array( 'url' => $url, 'method' => 'GET', 'header' => $header );
             */
            // $cUrl->init($params);
            $result = $this->exec();
            if (!empty($result ['curl_error'])) {
                throw new Exception('(Curl error) Failed to get content (' . $url . '), Error => ' . $result ['curl_error']);
            }
            if ($result ['http_code'] != '200') {
                throw new Exception('(Error 200) Failed to get content (' . $url . ')');
                // throw new Exception("HTTP Code = ".$result['http_code']);
            }
            $content = $result ['body'];
            if (mb_detect_encoding($content, 'UTF-8', true) != 'UTF-8') {
                $content = Encoding::toUTF8($content);
            }
        } catch (Exception $e) {
            Core_Log::getInstance()->log($e,'error');
        }
        return $content;
    }

    public function request($url) {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        $this->exec();
    }

    public function getImage($url) {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_BINARYTRANSFER, 1);
        $result = $this->exec();
        return $result ['body'];
    }

    public function setOpt($name, $value) {
        curl_setopt($this->ch, $name, $value);
    }

    public function multiRequests($params, $times, $delay = 1000) {
        $curlMultiHandle = curl_multi_init();
        $curlHandles = array();
        $responses = array();
        $i = 0;
        while ($i < $times) {
            $curlHandles [$i] = $this->initCurl($params);
            curl_multi_add_handle($curlMultiHandle, $curlHandles [$i]);
            $i ++;
        }

        $running = null;
        do {
            $ready = curl_multi_select($curlMultiHandle);
            $rv = curl_multi_exec($curlMultiHandle, $running);
            echo 'rv= ' . $rv . '; ready = ' . $ready . PHP_EOL;
            sleep($delay);
        } while ($running > 0);
        print_r(curl_multi_info_read($curlMultiHandle));
        foreach ($curlHandles as $id => $handle) {
            $responses [$id] = curl_multi_getcontent($handle);
            curl_multi_remove_handle($curlMultiHandle, $handle);
        }
        curl_multi_close($curlMultiHandle);
        return $responses;
    }

}
