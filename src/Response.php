<?php

namespace andkab\Turnstile;

class Response
{
    /**
     * @var boolean
     */
    public $success = false;

    /**
     * Errors of resolving captcha
     *
     * @var array<string>
     */
    public $errorCodes = [];

    /**
     * Date of resolving captcha
     *
     * @var string
     */
    public $challengeTs;

    /**
     * The domain from which the captcha was resolved
     *
     * @var string
     */
    public $hostname;

    /**
     * Check if exists any error from resolving
     *
     * @return boolean
     */
    public function hasErrors()
    {
        return !empty($this->errorCodes);
    }
    
    /**
     * Returns true/false depending on success
     *
     * @return boolean
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * Deserialize json response to response object class
     *
     * @param string $jsonResponse
     * @return \andkab\Turnstile\Response
     */
    public static function deserialize(string $jsonResponse)
    {
        $response = new self;
        $deserializedResponse = json_decode($jsonResponse, true);

        if (!$deserializedResponse || empty($deserializedResponse)) {
            return $response;
        }

        $response->success = $deserializedResponse['success'];
        $response->errorCodes = $deserializedResponse['error-codes'];
        $response->challengeTs = $deserializedResponse['challenge_ts'] ?? null;
        $response->hostname = $deserializedResponse['hostname'] ?? null;

        return $response;
    }
}
