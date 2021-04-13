<?php
namespace A\Acl;

use A\Acl as Assembly;

class Instance
{
    /**
     * @var array
     */
    protected $_entries = [];

    /**
     * @var array
     */
    protected $_parents = [];

    /**
     * @param mixed $accessor
     * @return A\Acl\Instance
     */
    public function extend($accessor) : Instance
    {
        array_unshift($this->_parents, $accessor);
        return $this;
    }

    /**
     * @param mixed $resource 
     * @param mixed $decision
     * @return A\Acl\Instance
     */
    public function handle($resource, $decision) : Instance
    {
        array_unshift($this->_entries, [$resource, $decision]);
        return $this;
    }

    /**
     * @param mixed $resource 
     * @return A\Acl\Instance
     */
    public function permit($resource) : Instance
    {
        return $this->handle($resource, 1);
    }

    /**
     * @param mixed $resource 
     * @return A\Acl\Instance
     */
    public function forbid($resource) : Instance
    {
        return $this->handle($resource, 0);
    }

    /**
     * @param A\Acl $assembly
     * @param mixed $accessor
     * @param mixed $resource
     * @return int|null
     */
    public function access(Assembly $assembly, $accessor, $resource) : ?int
    {
        if ($comparer = $assembly->getComparer())
        {
            foreach ($this->_entries as [$register, $decision])
            {
                if ($comparer($register, $resource))
                {
                    if (is_int($decision))
                    {
                        return $decision;
                    }
                    else if (is_int($decision = $decision($assembly, $accessor, $resource)))
                    {
                        return $decision;
                    }
                }
            }
        }

        foreach ($this->_parents as $accessor)
        {
            if (is_int($decision = $assembly->access($accessor, $resource)))
            {
                return $decision;
            }
        }

        return null;
    }
}
