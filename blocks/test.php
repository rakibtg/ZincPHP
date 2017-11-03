<?php
  // Define rules.
  $rules = [
    'name' => [
      'rules' => 'required|lengthMax:5|alphaNum|slug',
      'error' => [
        'required' => '{label} is required.',
      ],
      'value' => 'sjdhsuxbs xh'
    ],
    'email' => [
      'rules' => 'required|email|different:full_name|length:5|contains:1ew|notContains:2ew|alpha',
      // 'error' => 'Email address is not valid',
      'value' => 'abcd'
    ],
    'age' => [
      'rules' => 'required|integer|min:18|max:20|between:20:30',
      'value' => 31,
    ],
    'username' => [
      'rules' => 'required|accepted|array|numeric|in:abc:xyz|notIn:sdsjd:sdsdsdw',
      'value' => 'sdsjd'
    ],
    'dance' => [
      'rules' => 'length:5|lengthBetween:10:20|lengthMin:100',
      'value' => 'yeahsdssadfasfadssgdsgfhghjfghdfgasdasddasdasdasdasdsfsdssadfasfadsgdsgasdasdasdasdsfghdfgasdasdaah'
    ],
    'myip' => 'ip',
    'url' => 'url'
  ];
  // Start validating.
  $validator->validate( $rules, 'get' );

