<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
        /*
         * An array of LDAP uids that should be promoted to
         * Administrators when logged in.
         * This mechanism prevents locking users out of the system
         * by accidentially demoting admins.
         */
        'superAdmin' => array(
    		'tuser',
    ),
);
