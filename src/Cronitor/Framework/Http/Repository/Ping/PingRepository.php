<?php declare (strict_types = 1);

namespace Cronitor\Framework\Http\Repository\Ping;

use Cronitor\Framework\Http\Repository\AbstractRepository;

class PingRepository extends AbstractRepository
{
    /**
     * Generic ping method to easily call endpoints with.
     *
     * @param string $endpoint A valid Cronitor ping URL endpoint.
     * @param array $parameters An associative array containing additional parameters.
     * @return RequestInterface
     */
    protected function ping ($endpoint, $parameters)
    {
        # @TODO
        // $url = $this->client::BASE_URL."/{$this->monitorId}/{$endpoint}";
        //
        // if ($this->authKey)
        //   $parameters["auth_key"] = $this->authKey;
        //
        // if ($parameters)
        //   $queryString = http_build_query($parameters)
        //   and $url .= "?{$queryString}";
        //
        // return file_get_contents($url);
        # return $this->client->get($endpoint, $parameters);
    }

    /**
     * Ping the URL endpoint for running a monitor.
     *
     * @param string $message Takes an optional message to be sent along the request.
     * @return RequestInterface
     */
    public function runMonitor (string $message = null)
    {
        if ($message)
            return $this->ping("run", ["msg" => $message]);
        return $this->ping("run");
    }

    /**
     * Ping the URL endpoint for finishing a monitor.
     *
     * @param string $message Takes an optional message to be sent along the request.
     * @return RequestInterface
     */
    public function completeMonitor (string $message = null)
    {
        if ($message)
            return $this->ping("complete", ["msg" => $message]);
        return $this->ping("complete");
    }

    /**
     * Ping the URL endpoint for failing a monitor.
     *
     * @param string $message Takes an optional message to be sent along the request.
     * @return RequestInterface
     */
    public function failMonitor (string $message = null)
    {
        if ($message)
            return $this->ping("fail", ["msg" => $message]);
        return $this->ping("fail");
    }

    /**
     * Ping the URL endpoint for pausing a monitor.
     *
     * @param int $duration An integer determining the amount of hours to pause the monitor for.
     * @return RequestInterface
     */
    public function pauseMonitor (int $duration)
    {
        return $this->ping("pause/{$duration}");
    }

    /**
     * Ping the URL endpoint for resuming a monitor.
     *
     * @return RequestInterface
     */
    public function resumeMonitor ()
    {
        return $this->ping("pause/0");
    }
}
