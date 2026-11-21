<?php

return [
    /*
    | Akun Super Admin pertama yang dibuat oleh SuperAdminSeeder.
    | Bila ADMIN_PASSWORD kosong, password acak akan dibuat dan ditampilkan di terminal.
    */
    'admin' => [
        'name' => env('ADMIN_NAME', 'Super Admin'),
        'email' => env('ADMIN_EMAIL', 'admin@sanggargitalestari.com'),
        'password' => env('ADMIN_PASSWORD'),
    ],
];
