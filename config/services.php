<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'google' => [
        'client_id' => '937733730410-oi3ck8dtfi9neklitdr3rlmhp52laarp.apps.googleusercontent.com',
        'client_secret' => 'vnqZ7DedvCdOclv2b-gsands',
        'redirect' => 'https://todolistgovind.herokuapp.com/auth/google/callback',
    ],

    'facebook' => [
        'client_id' => '637254249952950',
        'client_secret' => 'f2472b48a668d3623e18f9f9276cc473',
        'redirect' => 'https://todolistgovind.herokuapp.com/auth/facebook/callback',
    ],


];
