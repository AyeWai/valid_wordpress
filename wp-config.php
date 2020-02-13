<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'valid_wordpress' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'non-root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', '123' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'e`(M=[-d{;Uv0W}TU5_Qh@p`Gx2jKo97)@uWyc6|G8Rt|;2t@mhKK9J|:cze|0]3' );
define( 'SECURE_AUTH_KEY',  'wI;&5_gbb5e3Rgj%wPZ13z_+,3,SP]/pknmSn:+[/{P~uyGVu5_`D?}7Yw[]Ml x' );
define( 'LOGGED_IN_KEY',    '~exql3g:.`7+K?HW13r&5OlgZeKAz5tSo>.MBYJN-@0t(4dEi1gajDw_|i+vVAjb' );
define( 'NONCE_KEY',        '%Oz$p:hV727we>!zfc6Jn~W~xPUF^9j~zL/R*7Fz}65hvJ%U]Fx$IQMyM@8OY=Lr' );
define( 'AUTH_SALT',        '|5YLU7R)Hr$2f4*e2EO8**qZ!9;1+?z4{Udx=k+,AR L!KBK=[Bj+s`]*jQ>S!H ' );
define( 'SECURE_AUTH_SALT', 'z1%Fp|ku1yOuIQj?]Dnygk=Hw*h($ikD0a%osj`IunjCrB+Gq0fBX[2[n(j0RdC ' );
define( 'LOGGED_IN_SALT',   '9,KYAWp03h*,6Vj=-qTJR_TNoGrf[wkSM%(.G32KncF8K6m<vfr*up]NrQ%U=CfE' );
define( 'NONCE_SALT',       'D%<{^=3nqa4CrxsaUMk#TltEeyO1%oyYm)Rkq=PNc h,<jTVt.C3I^hV#Xv|Jr`n' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'val_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
