<?php

$testWord = 'testing';
$result = [];
$sha0 = explode(' ', exec('echo -n "testing"|openssl dgst -sha -r'));
$result['sha-sha0'] = [
  'sha' => '0',
  'length' => (int)strlen(trim($sha0[0])),
  'word' => $testWord,
  'hash' => trim($sha0[0]),
];
foreach(hash_algos() as $algo)
{
    if(false === (bool)preg_match('/(sha)/', $algo))
    {
      continue;
    }
    $hash = hash($algo, $testWord);
    $filtered = preg_replace(['/sha/i', '/\//'], ['','-'], $algo);
    $result[preg_replace('/\//', '-', $algo)] = [
      'sha' => $filtered,
      'length' => (int)strlen($hash),
      'word' => $testWord,
      'hash' => $hash,
    ];
}

file_put_contents('known.json', json_encode($result, JSON_PRETTY_PRINT));