<?php

/*
'Illuminate\Foundation\Validation\ValidationException', 'LogicException', 'Illuminate\Validation\ValidationException'*/
return [
    'project_name' => env("APP_NAME", "OrgWebTech Master"),
    'notify_emails' => ['savaliya11.ketan@gmail.com'],
    'email_template' => 'errors.notifyException',
    'notify_environment' => ['production'],
    'prevent_exception' => ['Illuminate\Auth\AuthenticationException', 'League\OAuth2\Server\Exception\OAuthServerException', 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException', 'Illuminate\Session\TokenMismatchException'],
];

