<?php
  // Define rules.
  $rules = [
    'name' => [
      'rules' => 'required|max:50',
      'error' => [
        'required' => 'Name is required.',
        'max'      => 'Name is too big.',
      ],
      'value' => 'Kazi Mehedi Hasan'
    ],
    'email' => [
      'rules' => 'required|email',
      'error' => 'Email address is not valid',
    ],
    'age' => 'required|integer',
    'username' => 'unique'
  ];
  // Start validating.
  $validator->validate( $rules, 'get' );

