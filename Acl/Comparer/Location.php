<?php
namespace A\Acl\Comparer;

use A\Acl\Comparer;

class Location implements Comparer
{
    /**
     * @var string
     */
    protected $_pattern;

    /**
     * @param mixed $pattern
     * @return void
     */
    public function __construct($pattern = '(^/?%s(?:$|/))iu')
    {
        $this->_pattern = (string)$pattern;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return (string)$this->_pattern;
    }

    /**
     * @param mixed $pattern
     * @param mixed $subject
     * @return bool
     */
    public function __invoke($pattern, $subject) : bool
    {
        return (bool)preg_match(sprintf($this->_pattern, (string)$pattern), (string)$subject);
    }
}
