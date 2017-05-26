<?php

namespace Cronitor;

class Monitor
{
  protected $monitorId;
  protected $authKey;
  protected $baseUrl;

  /**
   * @param string $monitorId The unique identifier for your monitor found on Cronitors' dashboard.
   * @param array $options An array of options to be passed to the monitor on construction (e.g., auth_key).
   */
  public function __construct (string $monitorId, array $options = [])
  {
    $this->monitorId = $monitorId;
    $this->authKey = $options["auth_key"] ?? "";
    $this->baseUrl = $options["base_url"] ?? "https://cronitor.link";
  }

  /**
   * Ping a Cronitor endpoint with optional parameters.
   *
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

    return file_get_contents($url);
  }

  /**
   * Ping the Cronitor /run endpoint with the ping method.
   *
   * @param string $message An optional message to be passed to Cronitor with a max char length of 2048.
   */
  public function run (string $message = null)
  {
    if ($message) return $this->ping("run", ["msg" => $message]);
    return $this->ping("run");
  }

  /**
   * Ping the Cronitor /complete endpoint with the ping method.
   *
   * @param string $message An optional message to be passed to Cronitor with a max char length of 2048.
   */
  public function complete (string $message = null)
  {
    if ($message) return $this->ping("complete", ["msg" => $message]);
    return $this->ping("complete");
  }

  /**
   * Ping the Cronitor /fail endpoint with the ping method.
   *
   * @param string $message An optional message to be passed to Cronitor with a max char length of 2048.
   */
  public function fail (string $message = null)
  {
    if ($message) return $this->ping("fail", ["msg" => $message]);
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
