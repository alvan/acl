<?php
namespace A\Acl;

interface Resource
{
    /**
     * @return string
     */
    public function __toString() : string;
}
