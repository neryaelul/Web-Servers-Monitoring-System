<?php
        $settings = [
            "AutomatedWorker" => [
                "v1.0" => [
                    "main" => "app.php",
                    "source" => "src/app/AutomatedWorker/v1.0"
                ]
            ],
            "database" => [
                "username" => "bylith",
                "password" => "8G2KCsWZsmxGknAb",
                "name" => "bylith",
                "host" => "localhost"
            ],
            "api" => [
                "v1.0" => [
                    "type" => "stable",
                    "name" => "v1.0",
                    "source" => "src/app/api/v1.0",
                    "main" => "app.php",
                    "last_update" => "2024-01-07",
                    "endpoints" => [
                        "webservers" => [
                            "name" => "webservers",
                            "operations" => [
                                "add" => [
                                    "name" => "Add",
                                    "type" => "POST",
                                    "permission" => 1
                                ],
                                "update" => [
                                    "name" => "Update",
                                    "type" => "PUT",
                                    "permission" => 1
                                ],
                                "get" => [
                                    "name" => "Get",
                                    "type" => "GET",
                                    "permission" => 1
                                ],
                                "delete" => [
                                    "name" => "Delete",
                                    "type" => "DELETE",
                                    "permission" => 1,
                                ]
                            ]
                        ],
                        "history" => [
                            "name" => "history",
                            "operations" => [
                                "get" => [
                                        "name" => "Get",
                                        "type" => "GET",
                                        "permission" => 1
                                ]
                            ]
                        ],
                        "tokens" => [
                            "name" => "tokens",
                            "operations" => [
                                "add" =>[
                                    "name" => "Add",
                                    "type" => "POST",
                                    "permission" => 2
                                ],
                                "get" => [
                                    "name" => "Get",
                                    "type" => "GET",
                                    "permission" => 2
                                ],
                                "delete" => [
                                    "name" => "Delete",
                                    "type" => "DELETE",
                                    "permission" => 2
                                ]
                            ]
                        ],
                        "emails" => [
                            "name" => "emails",
                            "operations" => [
                                "add" =>[
                                    "name" => "Add",
                                    "type" => "POST",
                                    "permission" => 2
                                ],
                                "get" => [
                                    "name" => "Get",
                                    "type" => "GET",
                                    "permission" => 2
                                ],
                                "delete" => [
                                    "name" => "Delete",
                                    "type" => "DELETE",
                                    "permission" => 2
                                ]
                            ]
                        ]
                    ],
                    "status" => [
                        "added_success" => [
                            "message" => "Added successfully!",
                            "code" => "201"
                        ],
                        "to_math_argument" => [
                            "message" => "To math argument",
                            "code" => "401"
                        ],
                        "existing_record" => [
                            "message" => "A record with this name already exists",
                            "code" => "401"
                        ],
                        "record_not_found" => [
                            "message" => "Record not found",
                            "code" => "404"
                        ],
                        "delete_success" => [
                            "message" => "Delete successfully!",
                            "code" => "201"
                        ],
                        "error_parameters" => [
                            "message" => "Invalid request parameters",
                            "code" => "400"
                        ],
                        "validate_error" => [
                            "message" => "Validate_error",
                            "code" => "401"
                        ],
                        "permission_error" => [
                            "message" => "Permission error",
                            "code" => "403"
                        ],
                        "error_parameter_protocol_type" => [
                            "message" => "Error parameter protocol type only SSH, FTP/S, HTTP/S  ",
                            "code" => "400"
                        ],
                        "error_parameters" => [
                            "message" => "Invalid request parameters",
                            "code" => "400"
                        ],
                        "request_method_not_allowed" => [
                            "message" => "Request method not allowed",
                            "code" => "401"
                        ],
                        "function_method_not_allowed" => [
                            "message" => "Function method not allowed",
                            "code" => "401"
                        ],
                        "source_type_not_allowed" => [
                            "message" => "Source type not allowed",
                            "code" => "401"
                        ],
                        "validate_email" => [
                            "message" => "This is not a valid email address",
                            "code" => "401"
                        ]
                        
                    ]
                ]
            ]
    ];
?>