<?php
return array(
        'dbParams' => array(
        		'database' => 'roombooking',
        		'hostname' => 'localhost',
        		'username' => 'root',
        		'password' => '',                         // Dont' check in passwords
        ),
        'ldap' => array(
                'server1' => array
                (
                		'host' => '127.0.0.1',
                		'accountDomainName' => 'roombooking.qu.tu-berlin.de',
                		'accountDomainNameShort' => 'roombooking.qu.tu-berlin.de',
                		'accountCanonicalForm' => 2,
                		'username' => 'CN=admin,DC=roombooking,DC=qu,DC=tu-berlin,DC=de',
                		'password' => '',                 // Dont' check in passwords
                		'baseDn' => 'DC=roombooking,DC=qu,DC=tu-berlin,DC=de',
                		'bindRequiresDn' => true
                )
        )
);