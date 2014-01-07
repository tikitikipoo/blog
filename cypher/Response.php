<?php
/**
 * Responseクラス
 *
 * 参考
 * https://github.com/mikecao/flight/blob/master/flight/net/Response.php
 *
 */
namespace cypher;

class Response {

    /**
     * @var int HTTP status
     */
    protected $status = 200;

    /**
     * @var array HTTP headers
     */
    protected $headers = array();

    /**
     * @var string HTTP response body
     */
    protected $body;

    public static $codes = array(
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',

        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',

        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',

        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported'
    );


    /**
     * Set the HTTP status of the response
     *
     * @param int $code HTTP
     * @return object Self refrence
     * throws \Exception if invalid status code
     */
    public function setStatusCode($code)
    {
        if (array_key_exists($code, self::$codes)) {
            $this->status = $code;
        } else {
            throw new \Exception('Invalid status code');
        }

        return $this;
    }


    /**
     * Adds a header to the reponse
     *
     * @param string|array $name Header name or array of name and values
     * @param string $value Header value
     * @return object Self reference
     */
    public function setHeader($name, $value = null)
    {
        if (is_array($name)) {

            foreach($name as $k => $v) {
                $this->headers[$name] = $value;
            }
        } else {
            $this->headers[$name] = $value;
        }
    }

    /**
     * Writes content to the response body.
     *
     * @param string $str Response content
     * @return object Self reference
     */
    public function write($str)
    {
        $this->body .= $str;

        return $this;
    }

    /**
     * Clears the reponse
     *
     * @return object Self reference
     */
    public function clear()
    {
        $this->status = 200;
        $this->headers = array();
        $this->body = '';

        return $this;
    }

    /**
     * Sets caching headers for the response.
     *
     * @param int|string $expires Expiration time
     * @param object Self refernce
     */
    public function cache($expires)
    {
        if ($expires === false) {
            $this->headers['Expres'] = 'Mon, 26 Jul 1997 05:00:00 GMT';
            $this->headers['Cache-Control'] = array(
                'no-store, no-cache, must-revalidate',
                'post-check=0, pre-check=0',
                'max-age=0'
            );
        } else {
            $expres = is_int($expires) ? $expires : strtotime($expires);
            $this->headers['Expires'] = gmdate('D, d M Y H:i:s', $expres) . ' GMT';
            $this->headers['Cache-Control'] = 'max-age=' . ($expres - time());
        }

        return $this;
    }

    /**
     * Sends the response
     */
    public function send()
    {
        if (!headers_sent()) {

            // send status code header
            if (strpos(php_sapi_name(), 'cgi') !== false) {
                header(
                    sprintf(
                        'Status: %d %s',
                        $this->status,
                        self::$codes[$this->status]
                    ),
                    true
                );
            } else {
                header(
                    sprintf(
                        '%s %d %s',
                        getenv('SERVER_PROTOCOL') ?: 'HTTP/1.1',
                        $this->status,
                        self::$codes[$this->status]
                    ),
                    true,
                    $this->status
                );
            }

            // send other heders
            foreach ($this->headers as $field => $value) {
                if (is_array($value)) {
                    foreach ($value as $v) {
                        header($field . ': ' . $v, false);
                    }
                } else {
                    header($field . ': ' . $value);
                }
            }

        }

        echo $this->body;
    }
}
