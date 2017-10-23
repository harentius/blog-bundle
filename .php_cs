<?php

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setCacheFile(__DIR__ . '/.php_cs.cache')
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@PHP56Migration' => true,
        'combine_consecutive_unsets' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_useless_else' => true,
        'no_useless_return' => true,
        'ordered_class_elements' => true,
        'ordered_imports' => true,
        'concat_space' => ['spacing' => 'one'],
        'psr4' => true,
        'strict_comparison' => true,
        'strict_param' => true,
        'phpdoc_align' => false,
        'phpdoc_order' => true,
        'phpdoc_separation' => false,
        'phpdoc_to_comment' => false,
        'no_empty_phpdoc' => false,
        'phpdoc_add_missing_param_annotation' => ['only_untyped' => false],
        'modernize_types_casting' => true,
        'no_php4_constructor' => true,
        'php_unit_construct' => true,
        'php_unit_strict' => true,
        'semicolon_after_instruction' => true,
        'doctrine_annotation_indentation' => true,
        'doctrine_annotation_spaces' => ['around_array_assignments' => false],
        'pre_increment' => false,
        'yoda_style' => false,
    ])
;
