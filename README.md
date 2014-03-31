pjroombooking
=============
This project aims to provide a web application for resource reservation and room booking for small to mid-size organisations.
It is a *ZEND2* application written in PHP and designed to run on a typical "LAMP"-Stack, making use of several third party components ([See LICENSE](LICENSE.md)).
For authentication the application requires an LDAP server to be accessible.

Stability
---------

Bear in mind that this software is currently in early beta state and might not be fit for production use.
Please submit issues you encounter to our [issue tracker](https://github.com/roombooking/pjroombooking/issues).

Prerequisites
-------------

In order to install *pjroombooking* the following prerequisites have to be met:

* *Apache* 2.2 or higher
* *MySQL* 5.1 or higher
* *PHP* 5.3.23 or higher

In order to make use of all the features in the front-end, users should access it with modern browsers (recent versions of Chrome, Firefox or Safari).

Installation
------------

1. Prepare *apache* to serve *ZEND2* properly by configuring your apache virtual host file as described in <http://framework.zend.com/manual/2.0/en/user-guide/skeleton-application.html#virtual-host>.
2. `git clone` the project into the root of the directory your virtual host is pointing to.
3. Prepare MySQL by running the queries in [create.sql](module/Application/data/create.sql) on an emtpy database.

Optional: If you do not want to start from scratch you can import dummy data to you database by running the queries in [populate.sql](module/Application/data/populate.sql) on the database you prepared in *3*.

Configuration
-------------

The application needs access to the following components:

1. An *LDAP* server to authenticate users with.
2. A *MySQL* database with the appropriate schema to store room reservations in.

Once both these components are up and running, create `config/autoload/local.php` and configure the application to connect to the servers like that:

```php
<?php
return array(
    	'dbParams' => array(
				'database' => 'roombooking',
				'hostname' => 'localhost',
				'username' => 'example',
				'password' => ''
		),
		'ldap' => array(
				'server1' => array
				(
						'host' => '192.168.0.1',
						'accountDomainName' => 'example.org',
						'accountDomainNameShort' => 'example.org',
						'accountCanonicalForm' => 2,
						'username' => 'CN=admin,DC=example',
						'password' => '',
						'baseDn' => 'DC=example',
						'bindRequiresDn' => true
				)
		)
);
?>
```

Coding Conventions
------------------

Code contributed should be written according to the ZEND2 coding standards (<http://framework.zend.com/wiki/display/ZFDEV2/Coding+Standards#CodingStandards-NamingConventions>).
If you use the generic *Eclipse* IDE or the *Zend Eclipse PDT* flavour, make sure to import the `.settings` folder along with the project.

Authors
-------
[See AUTHORS](AUTHORS.md)

License
-------
[See LICENSE](LICENSE.md)
