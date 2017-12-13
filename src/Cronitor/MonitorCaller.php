<?php declare(strict_types = 1);

namespace Cronitor;

/**
 * @version 2.0.0
 * @since 0.0.1
 *
 * @author Jordan Brauer <jbrauer.inc@gmail.com>
 */
class MonitorCaller
{
    /**
     * @var string $id The unique ID of the monitor being called.
     */
    private $id;

    private $client;

    /**
     * Public constructor for the monitor caller object.
     *
     * @param array $settings
     */
    public function __construct (array $settings = [])
    {
        $this->client = new Client([
            "base_uri" => Client::PING_URL,
            "auth_key" => $this->authKey,
        ]);
    }

    /**
     * Ping a Cronitor endpoint with optional parameters.
     *
     * @param string $endpoint A valid Cronitor endpoint to be pinged (see Cronitor docs for info).
     * @param array $parameters An array of URL query string parameters that will be appended to the ping.
     */
    public function ping (string $endpoint, array $parameters = null)
    {
        # @TODO
        return $this->client->get($endpoint, $parameters);
    }

    /**
     * Ping the Cronitor /run endpoint with the ping method.
     *
     * @param string $message An optional message to be passed to Cronitor with a max char length of 2048.
     */
    public function run (string $message = null)
    {
        if ($message)
            return $this->ping("run", ["msg" => $message]);
        return $this->ping("run");
    }

    /**
     * Ping the Cronitor /complete endpoint with the ping method.
     *
     * @param string $message An optional message to be passed to Cronitor with a max char length of 2048.
     */
    public function complete (string $message = null)
    {
        if ($message)
            return $this->ping("complete", ["msg" => $message]);
        return $this->ping("complete");
    }

    /**
     * Ping the Cronitor /fail endpoint with the ping method.
     *
     * @param string $message An optional message to be passed to Cronitor with a max char length of 2048.
     */
    public function fail (string $message = null)
    {
        if ($message)
            return $this->ping("fail", ["msg" => $message]);
        return $this->ping("fail");
    }

    /**
     * Ping the Cronitor /pause endpoint with the ping method.
     *
     * @param integer $duration A duration in hours to pause the monitor for (see Cronitor docs for more info).
     */
    public function pause (int $duration)
    {
        return $this->ping("pause/{$duration}");
    }

    /**
     * Ping the Cronitor /pause endpoint with a duration of 0 to unpause the monitor.
     */
    public function resume ()
    {
        return $this->ping("pause/0");
    }
}
