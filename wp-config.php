<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'plugin' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'F}i1Rn7]w4#fT/^o8gVAXA,ty~K@Ef/3_s}:s>D9$|_Dn7Z=.u;xw*g{fU7O(C^H' );
define( 'SECURE_AUTH_KEY',  '*oJ]BK!RIQz|?Kt6^@%]p.L}Hwc@;h:c9kBaBYK7$-[Z_nx;BJ6C[3%,Tu$}}M*i' );
define( 'LOGGED_IN_KEY',    '!l|@5a.XWO]<}|7>_%0_uNfME|/Jh53t9/JdWqW*h.M4u1MktfI_A;%7yoDJmg@8' );
define( 'NONCE_KEY',        '%HC8PdG,Tw$)Q4ogNEwPm>0d1Kut 9.sf#[>2<sMA3C(;#d-DmeI/[p!ryP-+hLi' );
define( 'AUTH_SALT',        'q.AOI*:]gfC`%FL>nW!P*<a9sgZA+%.2^pUE>@V+bcM@);Oq3fw](i#o5U`4GFkQ' );
define( 'SECURE_AUTH_SALT', '2AT;1BhDSLH!oaK1*f/@LfmolFc[?i[tla~)n7yRpxrI8k$)au$}X5qr!n35W]}D' );
define( 'LOGGED_IN_SALT',   '[kA_I`=Wl<^+_*}GB4?7&ey9]ce4&Wm7M4!q4~W+[[Rxr6^peBiPE,{jh.~_~;KF' );
define( 'NONCE_SALT',       '!Oz#Q,KWMT*zQ|F~oP}ZUR#W_74wT&0VqTa{p,Am3W8lQ=pyGFp2?;IF|fVg=vkg' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'pl_';

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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
