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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'tester' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'qG8eQ%4DKVE5EZgHH/@[cvTb-c6?[R:MP/M`NEgh(}Y[_ .!4jk6+p4qqpDr(vKB' );
define( 'SECURE_AUTH_KEY',  '[_c%+)]nq<G8sjv8=Ht)X+0q1$wNIUHjSN(;/mb#yXWVjFz!D(X2,I/7YvXplWa,' );
define( 'LOGGED_IN_KEY',    '(k$dUJv0y$6k[:BD~0pXyuGU>!U {AY$*HVt5_m1 (Wl`lSd}bmfV&8tCaM~!v3[' );
define( 'NONCE_KEY',        'x2L>nWA8a~KsSng~iUTsc|45FsxtRINV~h~O<4BjUcD0;Zz-bKC{#!$k# V~P7h!' );
define( 'AUTH_SALT',        'Pgeu!(-iMpnPHaHPS_3O!H*5y1N~*+2q{;-| $_,G^jv>peR0FP9ju^#kq_9<%s{' );
define( 'SECURE_AUTH_SALT', 'w,8Ft=m2glroLB<Z}Io_sL1JR(6_r2o7ZY>0,x^`g@;tIKubWVHy9hgLo;uBaR-g' );
define( 'LOGGED_IN_SALT',   'C6P,#a(Ior/Vo@:P4suoSq&VD|P,@tPnqa#m~>,:P?)DJ)U)*As]*D9kh!VQFv :' );
define( 'NONCE_SALT',       '07`*HlIiCvxR,{3iVIN[$$R+8%pWS=5=<XtIj%5[2@F[|uZj(eg}Ou_!h/`]qLa{' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
