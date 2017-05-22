<?php
/**
 * Avatar API
 *
 * @author Fact Maven
 * @link https://www.factmaven.com/api/avatar
 * @version 1.1.0
 */

# Headers
header( "Access-Control-Allow-Origin: *" );
header( "Content-Type: application/json" );
ini_set( "user_agent","Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36" );

# Special properties
$link = ( isset($_SERVER['HTTPS'] ) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$meta = [
    "version" => "1.1.0",
    "copyright" => "Copyright 2011-" . date("Y") . " Fact Maven Corp.",
    "link" => "https://www.factmaven.com/",
    "authors" => [
    "Ethan Jinks O'Sullivan",
    ]
];

if ( count( $_GET ) ) {
    # Convert email into MD5 hash
    if ( isset( $_GET['email'] ) ) {
        $email = $_GET['email'];
        $hash = md5( strtolower( $email ) );
    }

    $gravatar = @file_get_contents( "https://gravatar.com/" . $hash . ".json" );
    if ( $gravatar === FALSE ) {
        $gravatar = "";
    }
    else {
        $gravatar = json_decode( $gravatar );
    }

    # Structure API
    $api = [
        "@link" => $link,
        "email" => $email,
        "hash" => $hash,
        "@source" => [
            "gravatar" => [
                "avatar" => [
                    "url" => "https://gravatar.com/avatar/" . $hash . "s=80&d=mm",
                    "jpg" => "https://gravatar.com/avatar/" . $hash . ".jpg",
                    "png" => "https://gravatar.com/avatar/" . $hash . ".png",
                ],
                "api" => $gravatar,
            ],
        ],
        "meta" => $meta,
    ];
}
else {
    $api = [
        "errors" => [
            "id" => "404",
            "title" => "Missing Parameter",
            "detail" => "Please start with adding '?email=name@example.com' at the end.",
        ],
        "meta" => $meta,
    ];
}
# Output JSON
print_r( json_encode( array_filter( $api ) ) );