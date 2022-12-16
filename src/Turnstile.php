<?php

namespace andkab\Turnstile;

class Turnstile
{
    /** @var string endpoint of cloudflare turnstile API */
    const API_ENDPOINT = 'https://challenges.cloudflare.com/turnstile/v0/';

    /** @var int default timeout */
    const DEFAULT_TIMEOUT = 15;

    /** @var string */
    private $secretKey;

    /** @var int */
    private $timeout = self::DEFAULT_TIMEOUT;

    /**
     * Turnstile constructor.
     * 
     * @param string $secretKey
     * @param int $timeout
     */
    public function __construct(string $secretKey, int $timeout = self::DEFAULT_TIMEOUT)
    {
        $this->setSecretKey($secretKey);
        $this->setTimeout($timeout);
    }
    
    /**
     * Setting of secret key
     * 
     * @param string $secretKey
     * 
     * @return void
     */
    public function setSecretKey(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * Setting of timeout resolving
     * 
     * @param int $seconds
     * 
     * @return void
     */
    public function setTimeout(int $seconds)
    {
        $this->timeout = $seconds;
    }

    /**
     * Verify captcha resolving
     *
     * @param string $response
     * @param string|null $remoteIp
     * @return \andkab\Turnstile\Response
     */
    public function verify(string $response, ?string $remoteIp = null)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => self::API_ENDPOINT . 'siteverify',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'secret' => $this->secretKey,
                'response' => $response,
                'remoteip' => $remoteIp
            ]),
        ]);

        $response = curl_exec($curl);
        
        curl_close($curl);

        return Response::deserialize($response);
    }
}
