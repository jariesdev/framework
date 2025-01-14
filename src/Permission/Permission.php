<?php

namespace AvoRed\Framework\Permission;

use AvoRed\Framework\Support\Contracts\PermissionInterface;
use Illuminate\Support\Facades\Lang;

class Permission implements PermissionInterface
{
    /**
     * @var string $label
     */
    protected $label;

    /**
     * @var string $routes
     */
    protected $routes;

    /**
     * @var string $key
     */
    protected $key;

    /**
     * Construct for a permission group
     * @param callable $callable
     * @return void
     */
    public function __construct($callable = null)
    {
        if (null !== $callable) {
            $callable($this);
        }
    }

    /**
     * Set/Get Label for permission
     * @param string $label
     * @return mixed $label|$this
     */
    public function label($label = null)
    {
        if (null !== $label) {
            $this->label = $label;

            return $this;
        }

        if (Lang::has($this->label)) {
            return __($this->label);
        }
        return $this->label;
    }

    /**
     * Set/Get key for permission
     * @param string $key
     * @return mixed $key|$this
     */
    public function key($key = null)
    {
        if (null !== $key) {
            $this->key = $key;

            return $this;
        }

        return $this->key;
    }
    
    /**
     * Set/Get routes for permission
     * @param string $routes
     * @return mixed $routes|$this
     */
    public function routes($routes = null)
    {
        if (null !== $routes) {
            $this->routes = $routes;

            return $this;
        }

        return $this->routes;
    }
}
