<?php declare(strict_types = 1);

namespace Cronitor;

use Cronitor\Framework\Http\Client\MonitorClient;
use Cronitor\Framework\Http\Repository\Ping\PingRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @version 2.0.0
 * @since 0.0.1
 *
 * @author Jordan Brauer <jbrauer.inc@gmail.com>
 */
class MonitorCaller
{
    private $repository;
    /**
     * Public constructor for the monitor caller object.
     *
     * @param array $settings
     */
    public function __construct (array $settings = [])
    {
        $settings = $this->configureSettings($settings, new OptionsResolver);
        $this->repository = new PingRepository(new MonitorClient($settings));
    }

    protected function configureSettings (array $settings = [], OptionsResolver $resolver): array
    {
        $resolver->setDefined(["auth_key", "id"]);
        $resolver->setDefaults([
            "secure" => true,
            "base_uri" => MonitorClient::BASE_URL,
        ]);
        if ($resolver->resolve($settings)["secure"] === true)
            $resolver->setRequired("auth_key");
        return $resolver->resolve($settings);
    }

    /**
     * Generic ping method to wrap the repository methods
     *
     * @param string $endpoint The name of the monitor action being invoked.
     * @param mixed $parameter Pass any additional parameters/data that the endpoint may require.
     * @return RequestInterface
     */
    protected function ping (string $endpoint, $parameter = null)
    {
        $method = $endpoint."Monitor";
        return $this->repository->$method($parameter);
    }

    /**
     * Ping the Cronitor /run endpoint with the ping method.
     *
     * @param string $message An optional message to be passed to Cronitor with a max char length of 2048.
     * @return RequestInterface
     */
    public function run (string $message = null)
    {
        return $this->ping("run", $message);
    }

    /**
     * Ping the Cronitor /complete endpoint with the ping method.
     *
     * @param string $message An optional message to be passed to Cronitor with a max char length of 2048.
     * @return RequestInterface
     */
    public function complete (string $message = null)
    {
        return $this->ping("complete", $message);
    }

    /**
     * Ping the Cronitor /fail endpoint with the ping method.
     *
     * @param string $message An optional message to be passed to Cronitor with a max char length of 2048.
     * @return RequestInterface
     */
    public function fail (string $message = null)
    {
        return $this->ping("fail", $message);
    }

    /**
     * Ping the Cronitor /pause endpoint with the ping method.
     *
     * @param integer $duration A duration in hours to pause the monitor for (see Cronitor docs for more info).
     * @return RequestInterface
     */
    public function pause (int $duration)
    {
        return $this->ping("pause", $duration);
    }

    /**
     * Ping the Cronitor /pause endpoint with a duration of 0 to unpause the monitor.
     *
     * @return RequestInterface
     */
    public function resume ()
    {
        return $this->ping("resume");
    }
}
