<?php
namespace A\Acl;

interface Comparer
{
    /**
     * @param mixed $pattern
     * @param mixed $subject
     * @return bool
     */
    public function __invoke($pattern, $subject) : bool;
}
