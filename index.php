<?php
/**
 * Avatar API
 *
 * @author      Ethan Jinks O'Sullivan
 * @link           https://api.factmaven.com/avatar
 * @version     1.0.0
 */

header( "Access-Control-Allow-Origin: *" );
header( 'Content-Type: application/json' );

# Hash email using parameter
$email = '';
if ( isset( $_GET['e'] ) ) {
    $email = $_GET['e'];
    $hash = md5( $email );
}
else {
    $hash = '';
}
# Define username parameter
$username = '';
if ( isset( $_GET['u'] ) ) {
    $username = $_GET['u'];
}

$api = [
    "hash" => $hash,
    "source" => [
        "gravatar" => [
            "avatar" => "https://gravatar.com/avatar/" . $hash,
            "default" => "https://gravatar.com/avatar/" . $hash . "?d=mm",
        ],
        "identicon" => [
            "url" => "https://github.com/identicons/",
            "avatarHash" => "https://github.com/identicons/" . $hash . ".png",
            "avatarUsername" => "https://github.com/identicons/" . $username . ".png",
        ],
        "adorable" => [
            "url" => "https://api.adorable.io/avatars/",
            "avatarHash" => "https://api.adorable.io/avatars/" . $hash,
            "avatarUsername" => "https://api.adorable.io/avatars/" . $username,
        ],
        "avatars.io" => [
            "url" => "https://avatars.io/",
            "avatarTwitter" => "https://avatars.io/twitter/" . $username,
            "avatarFacebook" => "https://avatars.io/facebook/" . $username,
            "avatarInstagram" => "https://avatars.io/instagram/" . $username,
        ],
    ],
];

print_r( json_encode( array_filter( $api ) ) );