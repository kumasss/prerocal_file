<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         's5PWrS9c1Q0/s2B7rM/VJDnjADVqW7pi6yFSK3DGpoW4CgPXFxmtWb5ENeKz1PYQjPrBfkpDKE79uQzbQyCPow==');
define('SECURE_AUTH_KEY',  'RarcI6L7CE26xqwvhKOHWVtstfRY8IM1Bawnw1JMHoKOgYdise6ITJqpFayETM7C0OE+o5d9KEBZ3ik8lrisDw==');
define('LOGGED_IN_KEY',    '7SWX53wZio6ha28YorhDdMrGidJLr4u/rS/syP/z1b3oakpdJ5rCjwiLij7Hg9N5ithmo+EORWFigX2GdJ22Eg==');
define('NONCE_KEY',        'Znv+WYyymtZhc+/2jB8iu63a7wU0QKZZUa5vQUnrpDUzdBBmADI/UzVPg4PksxzDDOOUxPrejucKtcwHN9jcXA==');
define('AUTH_SALT',        'pGqWVgirG2LgMG6uNCVYwwnXePEStlYVWyjfZCzVBXDiiyY1o9KxNYYm0RFSFgvHG42ivS5B1NXHzOoSJzFh9g==');
define('SECURE_AUTH_SALT', 'gPOr559gk1V57tcm4V9XKRMROqFG8qp+9htANq//kueHoRlBEeZzZOhNMEzbYeFw+yU9lG60w6skKtvWMarJ5A==');
define('LOGGED_IN_SALT',   'Fp4jZ7aSXVXkhSJYU5eGjIv9es2Z7x8ABbqoptbijltDh0r8x2ThdGQUJKXfKUqSN0dE/pml28DVVTe01RKnWw==');
define('NONCE_SALT',       'ssSLfLjpU4bpUkyIQvHmRMYKJhL4Nxwm1owoo7mq7GeViCvtwHPZYx/+YVb5VP1VJfRtiGNV8Qy7QyXJcvdDfQ==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
