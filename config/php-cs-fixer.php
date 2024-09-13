<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__ . '/../app')
    ->name('*.php')
    ->notPath('tests')
    ->exclude(['migrations', 'database', 'resources']);

return (new Config())
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'binary_operator_spaces' => [
            'default' => 'single_space',
            'operators' => ['=>' => 'align_single_space'],
        ],
        'no_extra_blank_lines' => [
            'tokens' => ['curly_brace_block', 'extra', 'parenthesis_brace_block', 'square_brace_block', 'throw', 'use'],
        ],
        'braces' => [
            'allow_single_line_closure' => true,
        ],
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
        ],
        'indentation_type' => true,
        'trim_array_spaces' => true,
        'single_quote' => true,
        'no_unused_imports' => true,
        'ordered_imports' => true,
        'semicolon_after_instruction' => true,
        'no_whitespace_before_comma_in_array' => true, 
        'return_type_declaration' => true,
        'no_empty_statement' => true,
        'strict_comparison' => true,
        'cast_spaces' => true,
        'phpdoc_align' => true,
        'phpdoc_no_empty_return' => true,
    ])
    ->setFinder($finder);