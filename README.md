About
-----

Another ACL (Access Control List).


Usage
-----

```php

    $acl = new A\Acl;
    $acl->setComparer(new A\Acl\Comparer\Location);
    $acl->setDiscover(new class implements A\Acl\Discover
    {
        /**
         * @param A\Acl $assembly
         * @param mixed $accessor
         * @return A\Acl\Instance|null
         */
        public function discover(A\Acl $assembly, $accessor) : ?A\Acl\Instance
        {
            $instance = null;
    
            if ($accessor)
            {
                $instance = $assembly->create();
    
                // Set default roles...
                $instance->extend('guest');
    
                // Try to retrieve ACL rules from database or other sources by specified accessor ID...
                // And then setup the acl instance...
                // ...
            }
    
            return $instance;
        }
    });
    
    $acl->create('admin')
        ->permit('.*')
    ;
    
    $acl->create('guest')
        ->forbid('.*')
        ->handle('admin/guess', function() : ?int {
            return date('n') % 2;
        })
        ->permit('admin/login')
        ->permit('index')
    ;
    
    // int(1)
    var_dump($acl->access('admin', 'admin/posts'));
    
    // int(0)
    var_dump($acl->access('guest', 'admin/posts'));
    
    // int(1) if the "month" value is an odd number
    var_dump($acl->access('guest', 'admin/guess'));
    
    // int(1)
    var_dump($acl->access('guest', 'admin/login'));
    
    // int(1)
    var_dump($acl->access('other', 'index/posts'));

```
