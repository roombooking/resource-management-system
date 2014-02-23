<?php
return array(
        'dbParams' => array(
        		'database' => 'roombooking',
        		'hostname' => 'localhost',
        		'username' => 'qu',
        		'password' => '557PqYeQyN5EYMxR',
        ),
        'ldap' => array(
                'server1' => array
                (
                		'host' => '192.168.178.25',
                		'accountDomainName' => 'roombooking.qu.tu-berlin.de',
                		'accountDomainNameShort' => 'roombooking.qu.tu-berlin.de',
                		'accountCanonicalForm' => 3,
                		'username' => 'CN=admin,DC=roombooking,DC=qu,DC=tu-berlin,DC=de',
                		'password' => 'r00mb00king',
                		'baseDn' => 'DC=roombooking,DC=qu,DC=tu-berlin,DC=de',
                		'bindRequiresDn' => true,
                ),
                'server2' => array
                (
                		'host' => '192.168.178.77',
                		'accountDomainName' => 'roombooking.qu.tu-berlin.de',
                		'accountDomainNameShort' => 'roombooking.qu.tu-berlin.de',
                		'accountCanonicalForm' => 3,
                		'username' => 'CN=admin,DC=roombooking,DC=qu,DC=tu-berlin,DC=de',
                		'password' => 'r00mb00king',
                		'baseDn' => 'DC=roombooking,DC=qu,DC=tu-berlin,DC=de',
                		'bindRequiresDn' => true,
                ),
//         		'server2' => array // AC
//         		(
//         				'host' => 'dc1.w.net',
//         				'useStartTls' => 1,
//         				'accountDomainName' => 'w.net',
//         				'accountDomainNameShort' => 'W',
//         				'accountCanonicalForm' => 3,
//         				'baseDn' => 'CN=Users,DC=w,DC=net',
//         		),
        ),
);