<?php
namespace A\Acl;

use A\Acl as Assembly;

interface Discover
{
    /**
     * @param A\Acl $assembly
     * @param mixed $accessor
     * @return A\Acl\Instance|null
     */
    public function discover(Assembly $assembly, $accessor) : ?Instance;
}
