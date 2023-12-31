<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "OPTIONS" => [
        "function" => 'option_course'
    ],
    "GET" => [
        "routes" => [
            [
                "params" => ["/^[0-9]{1,}$/", "/^[0-9]{1,}$/"],
                "function" => 'get_all_course_page_amount'
            ],
            [
                "params" => ["/^[0-9]{1,}$/"],
                "function" => 'get_course'
            ],
            [
                "params" => ["/^name$/", "/^[0-9]{1,}$/"],
                "function" => 'get_course_name'
            ]
        ]
    ],
    "POST" => [
        "params" => [],
        "function" => 'post_course'
    ],
    "PUT" => [
        "params" => [],
        "function" => 'put_course'
    ],
    "DELETE" => [
        "params" => ["/^[0-9]{1,}$/"],
        "function" => 'del_course'
    ]
];

$course_module = new Module($dict);