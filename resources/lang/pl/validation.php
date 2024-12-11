<?php

return [
    'required' => 'Pole :attribute jest wymagane.',
    'email' => 'Pole :attribute musi być prawidłowym adresem e-mail.',
    'regex' => 'Format pola :attribute jest nieprawidłowy.',
    'min' => [
        'numeric' => 'Pole :attribute musi być nie mniejsze niż :min.',
        'string' => 'Pole :attribute musi mieć co najmniej :min znaków.',
    ],
    'max' => [
        'numeric' => 'Pole :attribute nie może być większe niż :max.',
        'string' => 'Pole :attribute nie może mieć więcej niż :max znaków.',
    ],
    'date' => 'Pole :attribute musi być prawidłową datą.',
    'after' => 'Pole :attribute musi być datą późniejszą niż :date.',
    'before' => 'Pole :attribute musi być datą wcześniejszą niż :date.',
    'numeric' => 'Pole :attribute musi być liczbą.',
    'integer' => 'Pole :attribute musi być liczbą całkowitą.',

    'attributes' => [
        'email' => 'adres e-mail',
        'check_in' => 'data zameldowania',
        'check_out' => 'data wymeldowania',
        'guests_number' => 'liczba gości',
        'first_name' => 'imię',
        'last_name' => 'nazwisko',
        'phone' => 'numer telefonu',
    ],

    'custom' => [
        'email' => [
            'required' => 'Prosimy podać adres e-mail.',
            'email' => 'Prosimy podać prawidłowy adres e-mail.',
            'regex' => 'Format adresu e-mail jest nieprawidłowy.',
        ],
        'check_in' => [
            'required' => 'Prosimy wybrać datę zameldowania.',
            'date' => 'Data zameldowania musi być prawidłową datą.',
            'after' => 'Data zameldowania musi być późniejsza niż dzisiaj.',
        ],
        'check_out' => [
            'required' => 'Prosimy wybrać datę wymeldowania.',
            'date' => 'Data wymeldowania musi być prawidłową datą.',
            'after' => 'Data wymeldowania musi być późniejsza niż data zameldowania.',
        ],
        'guests_number' => [
            'required' => 'Prosimy podać liczbę gości.',
            'numeric' => 'Liczba gości musi być liczbą.',
            'min' => 'Minimalna liczba gości to :min.',
            'max' => 'Maksymalna liczba gości to :max.',
        ],
    ],
];
