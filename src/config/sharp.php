<?php

return [
    "entities" => [
        "category" => [
            "list" => \App\Sharp\CategorySharpList::class,
            "form" => \App\Sharp\CategorySharpForm::class,
//            "validator" => \App\Sharp\SpaceshipSharpValidator::class,
//            "policy" => \App\Sharp\Policies\SpaceshipPolicy::class
        ],
        "categoryLink" => [
            "list" => \App\Sharp\CategoryLinkSharpList::class,
        ],
        "book" => [
            "list" => \App\Sharp\BookSharpList::class,
        ]
    ],

    "menu" => [
        [
            "label" => "DB data",
            "icon" => "fa-superpowers",
            "entities" => [
                [
                    "label" => "Categories",
                    "icon" => "fa-tags",
                    "entity" => "category"
                ],
                [
                    "label" => "Category links",
                    "icon" => "fa-link",
                    "entity" => "categoryLink"
                ],
                [
                    "label" => "Books",
                    "icon" => "fa-book",
                    "entity" => "book"
                ],
            ]
        ]
    ],

    "auth" => [
//        "guard" => "sharp",
//        "login_attribute" => "login",
//        "password_attribute" => "pwd",
//        "display_attribute" => "name",
    ]
];