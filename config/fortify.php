<?php

use Laravel\Fortify\Features;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;

return [
    'guard' => 'web',

    'passwords' => 'users',

    'username' => 'email',

    'home' => '/assets',

    'prefix' => '',

    'middleware' => ['web'],

    'features' => [
        // Disable registration as per requirements
        // Features::registration(),
        Features::resetPasswords(),
        Features::emailVerification(),
        Features::updateProfileInformation(),
        Features::updatePasswords(),
        Features::twoFactorAuthentication(),
    ],
];
