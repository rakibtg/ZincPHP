<?php

  // Define rules.
  $rules = [
    'name' => [
      'rules' => 'required|lengthMax:5|alphaNum|slug',
      'error' => [
        'required' => '{label} is required.',
      ],
      'value' => 121
    ],
    'email' => [
      'rules' => 'required|email',
      'error' => 'Email address is not valid',
      'value' =>'test@test.com'
    ]
  ];

  // Start validating.
  $validator->validate( $rules, 'get' );

  _output( 'This is not the end...' );