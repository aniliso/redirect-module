<?php

namespace Modules\Redirect\Events;

use Illuminate\Queue\SerializesModels;

class NotFoundHttpEventHandler
{
    use SerializesModels;

    private $url;
    private $statusCode;
    private $ip;

    /**
     * Create a new event instance.
     *
     * @param $url
     * @param $lang
     */
    public function __construct($url, $ip, $statusCode)
    {
        $this->url = $url;
        $this->ip = $ip;
        $this->statusCode = $statusCode;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
