<?php declare(strict_types = 1);

namespace Cronitor\Component\Notification;

use Cronitor\Framework\Validation\ValidationInterface;

abstract class AbstractNotification implements ValidationInterface
{
    const TYPE = null;

    /**
     * @var string $data The notification email to be used.
     */
    private $data;

    /**
     * Public constructor function
     *
     * @param string $data The notification email to be used.
     */
    public function __construct (string $data)
    {
        $this->validate($data);
        $this->data = $data;
    }

    public function __call ($method, $args)
    {
        $magicMethod = $this->detectMethodAction($method) . $this->detectMethodProperty();
        if ($magicMethod !== $method)
            throw new \BadMethodCallException("Unknown magic method {$method}() for ".get_called_class().". Did you mean {$magicMethod}()?");
        return $this->data;
    }

    protected function detectMethodProperty ()
    {
        return ucfirst(rtrim(static::TYPE, "s"));
    }

    protected function detectMethodAction (string $method)
    {
        $actions = ["get"];
        $action = substr($method, 0, 3);
        if (in_array($action, $actions) === false)
            throw new \OutOfBoundsException("Unknown method action {$action}. Use one of ".implode(", ", $actions));
        return $action;
    }

    public function getData ()
    {
        return $this->data;
    }

    abstract public function validate ($data): bool;
}
