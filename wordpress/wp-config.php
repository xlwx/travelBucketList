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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'bucketList');

/** MySQL database username */
define('DB_USER', 'troDev');

/** MySQL database password */
define('DB_PASSWORD', '7d3yrq^Rwi2~Pgu');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '%0?9_x6)Py!oyH2U62pT*RYd`WCT}x}mD3tOVu|D/d4W#/jADr&5N8y82Mua, EM');
define('SECURE_AUTH_KEY',  '#AQYskRxPCSTlO=Ap[<vBB iCWh-,`8P^%3wzmt/k7SXHucK/U8E(B&[~i;q^xW2');
define('LOGGED_IN_KEY',    '53%v._qSj~~iLY0&Q8rT#Zj@%b*dpB3>6;/5%jzT[/U_P}krWnnak]]0Xjg.Qh#5');
define('NONCE_KEY',        ';}_xf>Zjd6XzT,/|Ut>e$%9>hK|8;/@L/Ha.]UwO02hwb?p5}GB+Vf%d$iox |r0');
define('AUTH_SALT',        'N@6EnFV 5~S*A8%j8=L?;Yk!14Q+9m>f`HBv,V.e^xI9VNuznVxyM/]VANzqqu0$');
define('SECURE_AUTH_SALT', 'Ahw:XFOf!]waKPrgrp xrjNSz<:^*-#+rkF1V<_[SZK2@N}wh  a``TTE ;HM%?Y');
define('LOGGED_IN_SALT',   'dvEw;,EtozJ!@=Ek)O[V<qYH|f_BMwO cH!lPwtEslqV{T,O*LJ2`BrnCpk,v{r/');
define('NONCE_SALT',       '=nrm!8-0I,Z$XPVN-hvZ}o9?v{p*sTwt]FBquKs3+e5_F9++{W}03/@rRPZel1|g');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);
define('FS_METHOD', 'direct');
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
