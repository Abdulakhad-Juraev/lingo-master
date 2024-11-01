<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'languageParam' => 'lang',
    'is_sms_test' => true,
    'languages' => [
        'uz' => "O'zbekcha",
        'ru' => "Русский",
        'en' => "English",
    ],
//    'jwt' => [
//        'issuer' => 'http://qdpi',  //name of your project (for information only)
//        'audience' => 'http://qdpi',  //description of the audience, eg. the website using the authentication (for info only)
//        'id' => '',  //a unique identifier for the JWT, typically a random string
//        'expire' => 300,  //the short-lived JWT token is here set to expire after 5 min.
//    ],
    'defaultLanguage' => 'uz',
];
