<?php 
return [

    'required' => 'The :attribute field is required.',
    'email' => 'The :attribute must be a valid email address.',
    'regex' => 'The :attribute format is invalid.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'string' => 'The :attribute must be at least :min characters.',
    ],
    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'string' => 'The :attribute may not be greater than :max characters.',
    ],
    'date' => 'The :attribute must be a valid date.',
    'after' => 'The :attribute must be a date after :date.',
    'before' => 'The :attribute must be a date before :date.',
    'numeric' => 'The :attribute must be a number.',
    'integer' => 'The :attribute must be an integer.',

    // Custom attribute names
    'attributes' => [
        'email' => 'email address',
        'check_in' => 'check-in date',
        'check_out' => 'check-out date',
        'guests_number' => 'number of guests',
        'first_name' => 'first name',
        'last_name' => 'last name',
        'phone' => 'phone number',
    ],

    'custom' => [
        'email' => [
            'required' => 'Please enter an email address.',
            'email' => 'Please enter a valid email address.',
            'regex' => 'The email format is invalid.',
        ],
        'check_in' => [
            'required' => 'Please select a check-in date.',
            'date' => 'The check-in date must be a valid date.',
            'after' => 'The check-in date must be after today.',
        ],
        'check_out' => [
            'required' => 'Please select a check-out date.',
            'date' => 'The check-out date must be a valid date.',
            'after' => 'The check-out date must be after the check-in date.',
        ],
        'guests_number' => [
            'required' => 'Please enter the number of guests.',
            'numeric' => 'The number of guests must be a number.',
            'min' => 'The minimum number of guests is :min.',
            'max' => 'The maximum number of guests is :max.',
        ],
    ],
];