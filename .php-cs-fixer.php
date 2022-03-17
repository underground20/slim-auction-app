<?php

declare(strict_types=1);

return
    (new PhpCsFixer\Config())
        ->setCacheFile(__DIR__ . '/var/cache/.php_cs')
        ->setFinder(
            PhpCsFixer\Finder::create()
                ->in([
                    __DIR__ . '/bin',
                    __DIR__ . '/config',
                    __DIR__ . '/public',
                    __DIR__ . '/src',
                    __DIR__ . '/tests',
                ])
                ->append([
                    __FILE__,
                ])
        )
        ->setRules([
            '@PSR12' => true,
            '@PSR12:risky' => true,
            '@PHP80Migration' => true,
            '@PHP80Migration:risky' => true,
            '@PHPUnit84Migration:risky' => true,

            'ordered_imports' => ['imports_order' => ['class', 'function', 'const']],
            'concat_space' => ['spacing' => 'one'],
            'cast_spaces' => ['space' => 'none'],
            'binary_operator_spaces' => false,
            'phpdoc_to_comment' => false,
            'phpdoc_separation' => false,
            'phpdoc_types_order' => ['null_adjustment' => 'always_last'],
            'phpdoc_align' => false,
            'operator_linebreak' => false,
            'blank_line_before_statement' => false,
            'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
            'fopen_flags' => ['b_mode' => true],
            'yoda_style' => false,
            'self_static_accessor' => true,
            'strict_comparison' => true,
            'strict_param' => true,
            'static_lambda' => true,

            'no_unused_imports' => true,
            'no_superfluous_elseif' => true,
            'no_useless_else' => true,
            'no_useless_return' => true,

            'php_unit_construct' => true,
            'php_unit_fqcn_annotation' => true,
            'php_unit_strict' => false,
            'php_unit_test_class_requires_covers' => false,
            'php_unit_test_case_static_method_calls' => ['call_type' => 'self'],
            'php_unit_set_up_tear_down_visibility' => true,
        ]);
