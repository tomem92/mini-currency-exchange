<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->exclude(['vendor', 'docker'])
    ->in(__DIR__);

$config = new PhpCsFixer\Config();
return $config->setRules([
    '@PSR12' => true,
    'strict_param' => true,
    'array_syntax' => ['syntax' => 'short'],
])
    ->setRiskyAllowed(true)
    ->setFinder($finder);
