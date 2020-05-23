<?php

return [
    'session'       => [
        'token' => FILTER_VALIDATE_INT, // TODO HASH
    ],

    'get'           => [
        'category'                  =>      [
            'filter' => FILTER_VALIDATE_INT,
            'flags'  => FILTER_FLAG_STRIP_BACKTICK
        ],
        'content'                   =>      [
            'filter' => FILTER_VALIDATE_INT,
            'flags'  => FILTER_FLAG_STRIP_BACKTICK
        ],
        'categories'        =>      [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags'  => FILTER_FLAG_STRIP_BACKTICK
        ],
        'title'             =>      [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags'  => FILTER_FLAG_STRIP_BACKTICK
        ],
        'id'                =>      [
            'filter' => FILTER_VALIDATE_INT,
            'flags'  => FILTER_FLAG_STRIP_BACKTICK
        ],
    ],

    'post'          => [
        'id'                 =>      [
            'filter' => FILTER_VALIDATE_INT,
            'flags'  => FILTER_FLAG_STRIP_BACKTICK
        ],
        'user_name'                 =>      [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags'  => FILTER_FLAG_STRIP_BACKTICK
        ],
        'content'                   =>      [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags'  => FILTER_FLAG_STRIP_BACKTICK
        ],
        'title'                     =>      [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags'  => FILTER_FLAG_STRIP_BACKTICK
        ],
        'category'                  =>      [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags'  => FILTER_FLAG_STRIP_BACKTICK
        ],
        'sub_category'              =>      [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags'  => FILTER_FLAG_STRIP_BACKTICK
        ],
        'image'                     =>      [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags'  => FILTER_FLAG_STRIP_BACKTICK
        ],
        'login_identifier'          =>      [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags'  => FILTER_FLAG_STRIP_BACKTICK
        ],
        'login_password'            =>      [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags'  => FILTER_FLAG_STRIP_BACKTICK
        ],

    ]
];
