<?php

return [
    "entities" => [
        "category" => [
            "list" => \App\Sharp\CategorySharpList::class,
//            "form" => \App\Sharp\SpaceshipSharpForm::class,
//            "validator" => \App\Sharp\SpaceshipSharpValidator::class,
//            "policy" => \App\Sharp\Policies\SpaceshipPolicy::class
        ],
        "book" => [
            "list" => \App\Sharp\BookSharpList::class,
//            "form" => \App\Sharp\SpaceshipSharpForm::class,
//            "validator" => \App\Sharp\SpaceshipSharpValidator::class,
//            "policy" => \App\Sharp\Policies\SpaceshipPolicy::class
        ]
    ],

    "auth" => [
//        "guard" => "sharp",
//        "login_attribute" => "login",
//        "password_attribute" => "pwd",
//        "display_attribute" => "name",
    ]
];