<?php
  // Define rules.
  $rules = [
    'name' => [
      'rules' => 'required|max:50',
      'error' => [
        'required' => '{label} is required.',
        'max'      => 'Name is too big.',
      ],
    ],
    'email' => [
      'rules' => 'required|email|different:full_name|length:5',
      // 'error' => 'Email address is not valid',
      'value' => 'asfasfas'
    ],
    'age' => [
      'rules' => 'required|integer',
      'value' => 'twenty',
    ],
    'username' => [
      'rules' => 'required|accepted|array|numeric',
      'value' => 'rakibtg'
    ],
    'dance' => [
      'rules' => 'length:5',
      'value' => 231241
    ]
  ];
  // Start validating.
  $validator->validate( $rules, 'get' );

