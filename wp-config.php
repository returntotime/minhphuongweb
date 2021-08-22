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
define( 'DB_NAME', 'minhphuongninesbeaury.vn' );

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
define( 'AUTH_KEY',         ';c0. 4T`V?vsW>;q_ cu%LrzgDw?BDx15m++l= 2l50O{iQ?K+1}Au{B5_G+6%Kc' );
define( 'SECURE_AUTH_KEY',  '/6lX1.haZUr$gH$9En%7;|t7d!CRvQ5~=Xo/aLpfmAb}x!1jrDykL6yp%pLq;C v' );
define( 'LOGGED_IN_KEY',    '80{PJw)rzfV{HR~{<p~ ZL{ehtT9ih=21^1yi84|~=-%DFE~l$IH5Qfa(Ppm#oSI' );
define( 'NONCE_KEY',        'SFTF81;tq~AFJd,(8le|d_Y+%lIh-1x{r=#KRszMt2_y,)C!6Eu&N/nkq=<b%Y%@' );
define( 'AUTH_SALT',        '7}fZ<,0=#6ntz=0n8eW-g]I%JQ[k#tZelf?MNi%_^c{wEuU/|FDW1u~4YndH4[|[' );
define( 'SECURE_AUTH_SALT', '.|#d+ZI_b.AR-_P(&<R!w5bKBfAHE$`hY:`Q]4erb>UA38qAS8c>;:EdTbDsJ>;k' );
define( 'LOGGED_IN_SALT',   'u[t[AGrHr+zG87bLnk=`9Yr,fj8(udplUD3]9JsB>W]yUq.Z5/Fi+zvB`q[hABJu' );
define( 'NONCE_SALT',       'v{;6A^}.KVAxP:{vu}m[&i)L)~RlSnx=twie.S@i^#%JaGNy(9hQYSDr;{HHPY;(' );

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
