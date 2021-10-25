<?php

namespace Osoobe\DlvrItApi;


/**
 * dlvr.it API class
 * 
 * @see https://api.dlvrit.com/1/help for Dlvir.it API Specification
 * 
 * Using the API
 * - Currently 'xml' (default) and 'json' formats are supported. The format is specified by changing the extension of the method name (e.g. .xml or .json)
 * - Variables are passed to the API via POST
 * - Your dlvr.it api key can be found in your dlvr.it account at Settings -> Account.
 * 
 * @method array|string getRoutes()         List routes.
 * @method array|string getAccounts()       List accounts.
 * @method array|string postToRoute()       Post to route or queue.
 * @method array|string postToAccount()     Post to account.
 * @method array|string urlShortener()      URL Shortener.
 * 
 */
class Request {

    protected $key = '';

    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * Convert XML to JSON
     * 
     * @see https://api.dlvrit.com/1/help for Dlvir.it API Specification
     *
     * @param SimpleXMLElement|string $xml
     * @return array
     */
    public static function xmlToJson($xml) {
        if ( is_string($xml) ) {
            $xml = simplexml_load_string($xml);
        }
        $json_str = json_encode($xml);
        return json_decode($json_str, true);
    }

    /**
     * List Routes
     * 
     * This method will simply return a list of your routes and their ids.
     * @see https://api.dlvrit.com/1/help for Dlvir.it API Specification
     *
     * @param string $format    xml, json
     * @return array
     */
    public function getRoutes(string $format='json') {
        $url = "https://api.dlvrit.com/1/routes.$format?key=$this->key";
        $data = $this->send($url);
        if ( $format == "json" ) {
            return json_decode($data, true);
        }
        return $data;
    }

    /**
     * List Queues
     * 
     * This method will simply return a list of your output accounts and their ids.
     * @see https://api.dlvrit.com/1/help for Dlvir.it API Specification
     *
     * @param string $format    xml, json
     * @return array
     */
    public function getAccounts(string $format='json') {
        $url = "https://api.dlvrit.com/1/accounts.$format?key=$this->key";
        $data = $this->send($url);
        if ( $format == "json" ) {
            return json_decode($data, true);
        }
        return $data;
    }

    /**
     * Post to a Route (or Queue)
     * 
     * This method will post a message to all the outputs of a route or Queue.
     * @see https://api.dlvrit.com/1/help for Dlvir.it API Specification
     *
     * @param mixed $id         Route or Queue id
     * @param string $msg       Message
     * @param array $params     HTTP Get Params for this endpoint
     *          shared (optional) - [0/1 - default 0] use shared url where applicable
     *          title (optional) - title to use if shared is set
     *          media (optional) - uploaded image (requires POST w/ multipart encoding)
     *          posttime (optional) - a future post time (only for Qs)
     *          order (optional) - 'first' or 'last', to specifiy order in Q
     *          queue (optional) - if set, post to the social Q
     * @param string $format    xml, json
     * @return array
     */
    public function postToRoute($id, $msg, array $params=[], string $format='json') {
        if ( empty($params) ) {
            $params = [];
        }
        $params['id'] = $id;
        $params['msg'] = $msg;
        $param_str = http_build_query($params);
        $url = "https://api.dlvrit.com/1/postToRoute.$format?key=$this->key&$param_str";
        $data = $this->send($url);
        if ( $format == "json" ) {
            return json_decode($data, true);
        }
        return $data;
    }

    /**
     * Post to an Account
     * 
     * This method will post a message to an output account.
     * @see https://api.dlvrit.com/1/help for Dlvir.it API Specification
     *
     * @param mixed $id         Route or Queue id
     * @param string $msg       Message
     * @param array $params     HTTP Get Params for this endpoint
     *          shared (optional) - [0/1 - default 0] use shared url where applicable
     *          title (optional) - title to use if shared is set
     *          media (optional) - uploaded image (requires POST w/ multipart encoding)
     *          posttime (optional) - a future post time (only for Qs)
     *          order (optional) - 'first' or 'last', to specifiy order in Q
     *          queue (optional) - if set, post to the social Q
     * @param string $format    xml, json
     * @return array
     */
    public function postToAccount($id, $msg, array $params=[], $format='json') {
        if ( empty($params) ) {
            $params = [];
        }
        $params['id'] = $id;
        $params['msg'] = $msg;
        $param_str = http_build_query($params);
        $url = "https://api.dlvrit.com/1/postToAccount.$format?key=$this->key&$param_str";
        $data = $this->send($url);
        if ( $format == "json" ) {
            return json_decode($data, true);
        }
        return $data;
    }


    /**
     * Request a short url
     * 
     * This method will return a shortened version of a url.
     * @see https://api.dlvrit.com/1/help for Dlvir.it API Specification
     *
     * @param string $url       Long URL
     * @param string $format    xml, json, text
     * @return array
     */
    public function urlShortener(string $url, string $format='json') {
        $url = "https://api.dlvrit.com/1/routes.$format?key=$this->key&url=$url";
        $data = $this->send($url);
        if ( $format == "json" ) {
            return json_decode($data, true);
        }
        return $data;
    }


    /**
     * Send Curl HTTP Request
     *
     * @param string $url
     * @return string
     */
    protected function send(string $url)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
          ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

}

?>