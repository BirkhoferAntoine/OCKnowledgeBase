<?php

return [
    'session'       => [
        'token' => FILTER_VALIDATE_INT, // TODO HASH
    ],

    'get'           => [
        'categories'        =>      [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags'  => FILTER_FLAG_STRIP_BACKTICK
        ],
        'title'        =>      [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags'  => FILTER_FLAG_STRIP_BACKTICK
        ],
        'id'        =>      [
            'filter' => FILTER_VALIDATE_INT,
            'flags'  => FILTER_FLAG_STRIP_BACKTICK
        ],
        /*'url'           =>    FILTER_SANITIZE_URL,
        'submit'        =>    FILTER_SANITIZE_STRING | FILTER_FLAG_NO_ENCODE_QUOTES,
        'editor'        =>    FILTER_SANITIZE_STRING | FILTER_FLAG_NO_ENCODE_QUOTES,
        'post'          =>    FILTER_SANITIZE_STRING | FILTER_FLAG_NO_ENCODE_QUOTES,
        'comment'       =>    FILTER_SANITIZE_STRING,
        'comments'      =>    FILTER_SANITIZE_STRING | FILTER_FLAG_NO_ENCODE_QUOTES,
        'flag'          =>    FILTER_SANITIZE_STRING,
        'accept'        =>    FILTER_VALIDATE_INT,
        'edit'          =>    FILTER_VALIDATE_INT,
        'delete'        =>    FILTER_VALIDATE_INT,
        'listrange'     =>    FILTER_VALIDATE_INT,
        'logout'        =>    FILTER_SANITIZE_STRING,
        'logedin'       =>    FILTER_SANITIZE_STRING*/
    ],
    'post'          => [
        'user_name@api'                 =>      [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags'  => FILTER_FLAG_STRIP_BACKTICK
        ],
        'content@api'                   =>      [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags'  => FILTER_FLAG_STRIP_BACKTICK
        ],
        'title@api'                     =>      [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags'  => FILTER_FLAG_STRIP_BACKTICK
        ],
        'login_identifier'              =>      [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags'  => FILTER_FLAG_STRIP_BACKTICK
        ],
        'login_password'                =>      [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags'  => FILTER_FLAG_STRIP_BACKTICK
        ],
        /*'commentEditor'                 =>    FILTER_SANITIZE_STRING | FILTER_FLAG_NO_ENCODE_QUOTES,
        'user'                          =>    FILTER_SANITIZE_STRING,
        'commentUser'                   =>    FILTER_SANITIZE_STRING,
        'flag'                          =>    FILTER_VALIDATE_INT,
        'accept'                        =>    FILTER_VALIDATE_INT,
        'edit'                          =>    FILTER_VALIDATE_INT,
        'delete'                        =>    FILTER_VALIDATE_INT,
        'postId'                        =>    FILTER_VALIDATE_INT,
        'postTitle'                     =>    FILTER_SANITIZE_STRING | FILTER_FLAG_NO_ENCODE_QUOTES,
        'postText'                      =>    FILTER_SANITIZE_STRING | FILTER_FLAG_NO_ENCODE_QUOTES,
        'postContent'                   =>    FILTER_SANITIZE_STRING | FILTER_FLAG_NO_ENCODE_QUOTES,
        'postUrlImage'                  =>    FILTER_SANITIZE_URL*/
    ],
    'allowedSQL'       => [
        'id', 'user_name', 'title', 'content', 'date', 'image',
    ],
];
