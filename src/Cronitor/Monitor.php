<?php

namespace Cronitor;

class Monitor
{
  protected $monitorId;
  protected $authKey;
  protected $baseUrl;

  public function __construct (string $monitorId, array $opts = [])
  {
    $this->monitorId = $monitorId;
    $this->authKey = $opts["auth_key"] ?? "";
    $this->baseUrl = $opts["base_url"] ?? "https://cronitor.link";
  }

  /**
   * Ping a Cronitor endpoint with optional parameters.
   * @method ping
   * @param string $endpoint A valid Cronitor endpoint to be pinged (see Cronitor docs for info).
   * @param array $parameters An array of URL query string parameters that will be appended to the ping.
   */
  public function ping (string $endpoint, array $parameters = null)
  {
    $url = "{$this->baseUrl}/{$this->monitorId}/{$endpoint}";

    if ($this->authKey)
      $parameters["auth_key"] = $this->authKey;

    if ($parameters)
      $queryString = http_build_query($parameters)
      and $url .= "?{$queryString}";

    // echo $url.PHP_EOL;
    return file_get_contents($url);
  }

  /**
   * Ping the Cronitor /run endpoint with the ping method.
   * @method run
   * @param string $message An optional message to be passed to Cronitor with a max char length of 2048.
   */
  public function run (string $message = null)
  {
    return $message ??
      $this->ping("run", ["msg" => $message]) ??
      $this->ping("run");
  }

  /**
   * Ping the Cronitor /complete endpoint with the ping method.
   * @method complete
   * @param string $message An optional message to be passed to Cronitor with a max char length of 2048.
   */
  public function complete (string $message = null)
  {
    return $message ??
      $this->ping("complete", ["msg" => $message]) ??
      $this->ping("complete");
  }

  /**
   * Ping the Cronitor /fail endpoint with the ping method.
   * @method fail
   * @param string $message An optional message to be passed to Cronitor with a max char length of 2048.
   */
  public function fail (string $message = null)
  {
    return $message ??
      $this->ping("fail", ["msg" => $message]) ??
      $this->ping("fail");
  }

  /**
   * Ping the Cronitor /pause endpoint with the ping method.
   * @method pause
   * @param integer $duration A duration in hours to pause the monitor for (see Cronitor docs for more info).
   */
  public function pause (int $duration)
  {
    return $this->ping("pause/{$duration}");
  }
}
