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
   * @param string $endpoint A valid Cronitor endpoint (see Cronitor docs for info).
   */
  public function ping (string $endpoint, array $parameters = null)
  {
    $url = "{$this->baseUrl}/{$this->monitorId}/{$endpoint}";

    if ($this->authKey)
      $parameters['auth_key'] = $this->authKey;

    if ($parameters)
      $queryString = http_build_query($parameters)
      and $url .= "?{$queryString}";

    // echo $url.PHP_EOL;
    return file_get_contents($url);
  }
}
