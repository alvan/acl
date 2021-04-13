<?php
/**
 * Another ACL (Access Control List)
 *
 * @category A
 * @package A\Acl
 * @copyright Copyright (c) 2017 Alvan
 * @license The MIT License (MIT)
 */
namespace A;

class Acl
{
    /**
     * @var A\Acl\Comparer
     */
    protected $_comparer;

    /**
     * @var A\Acl\Discover
     */
    protected $_discover;

    /**
     * @var A\Acl\Registry
     */
    protected $_registry;

    /**
     * @var mixed
     */
    protected $_instance = Acl\Instance::class;

    /**
     * @param A\Acl\Comparer|null $comparer
     * @return void
     */
    public function setComparer(?Acl\Comparer $comparer) : void
    {
        $this->_comparer = $comparer;
    }

    /**
     * @return A\Acl\Comparer|null
     */
    public function getComparer() : ?Acl\Comparer
    {
        return $this->_comparer;
    }

    /**
     * @param A\Acl\Discover|null $discover
     * @return void
     */
    public function setDiscover(?Acl\Discover $discover) : void
    {
        $this->_discover = $discover;
    }

    /**
     * @return A\Acl\Discover|null
     */
    public function getDiscover() : ?Acl\Discover
    {
        return $this->_discover;
    }

    /**
     * @param A\Acl\Registry $registry
     * @return void
     */
    public function setRegistry(Acl\Registry $registry) : void
    {
        $this->_registry = $registry;
    }

    /**
     * @return A\Acl\Registry
     */
    public function getRegistry() : Acl\Registry
    {
        return $this->_registry ?? $this->_registry = new Acl\Registry;
    }

    /**
     * @param mixed $instance
     * @return mixed
     */
    public function mapInstance($instance = null)
    {
        if (isset($instance))
        {
            $this->_instance = $instance;
        }

        return $this->_instance;
    }

    /**
     * @param mixed $accessor
     * @param mixed $resource
     * @return int|null
     */
    public function access($accessor, $resource) : ?int
    {
        return ($instance = $this->locate($accessor)) ? $instance->access($this, $accessor, $resource) : null;
    }

    /**
     * @param mixed $accessor
     * @return A\Acl\Instance
     */
    public function create($accessor = null) : Acl\Instance
    {
        $instance = new $this->_instance;
        if (isset($accessor))
        {
            $this->getRegistry()[(string)$accessor] = $instance;
        }

        return $instance;
    }

    /**
     * @param mixed $accessor
     * @return A\Acl\Instance|null
     */
    public function locate($accessor) : ?Acl\Instance
    {
        $instance = $this->getRegistry()[(string)$accessor] ?? null;

        if (!$instance)
        {
            if ($discover = $this->getDiscover())
            {
                $instance = $discover->discover($this, $accessor);
                if ($instance)
                {
                    $this->getRegistry()[(string)$accessor] = $instance;
                }
            }
        }

        return $instance;
    }
}
