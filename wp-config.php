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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'scorelens' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          '4dkfnPu2.[Y}H1ruC~W:<b@5lHME8Hg/08/{?+T`W#+RK!+_@)2/TgJiA|2cd{1)' );
define( 'SECURE_AUTH_KEY',   ' c`HcWKp2M1}dI$RCVN0N D^AR]nH~+nqKyL%G>ZfaCNb?YZ]ddx}O(Z)}%J&oq_' );
define( 'LOGGED_IN_KEY',     'eP4bVK&0^}YgjAp;k1WJa?}=l;VGV.lE.kY.-O}ot@Su#r%]m+t2$IX4SlwY.sQL' );
define( 'NONCE_KEY',         '$cUBj1E{z9>J.3`4f+fVQJvg0>lubSByqFM&GkM`)fBOt2C>X,2y3!4H<llDkW9r' );
define( 'AUTH_SALT',         'h)+32[^[oHd``)yKrqP3N|,uarXolqalw$rgj6TAMcfi.8Lih:S5thT9QkU!hhB%' );
define( 'SECURE_AUTH_SALT',  '/_rHD+fW:*BWS*Gk47+OAjbiv;,C0:C6&{=X908Cp[jMxg$}$<M=5h/=~xi+I+b4' );
define( 'LOGGED_IN_SALT',    '44N$sJ8x#8#m,]6&?DA`0L0+ir5#Tp%AlJZ||M_OcY`Ng;raNm@7Nw3}x+gXyOZ@' );
define( 'NONCE_SALT',        'Y/PuHoB|n`?:cg3G:Z=2[pF?-_bsKJL29ADmVsI5Z7V;.qD}/=l`YXV<Asd0-E8w' );
define( 'WP_CACHE_KEY_SALT', 'm*/^lG_XIkYSa9RJAZP Na[Z@yUQ_X+A}sU-.osM3Kjh7sp9KKQv:h~HDwcj,@|!' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
