<?php declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->ignoreVCSIgnored(true)
    ->path('src/')
    ->path('tests/')
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();

return $config
    ->setRiskyAllowed(true)
    ->setRules([
        '@PHP71Migration' => true,
        '@Symfony:risky' => true,
        'array_syntax' => ['syntax' => 'short'],
        'combine_consecutive_unsets' => true,
        'modernize_types_casting' => false,
        // one should use PHPUnit methods to set up expected exception instead of annotations
        'heredoc_to_nowdoc' => true,
        'no_extra_blank_lines' => true,
        'echo_tag_syntax' => ['format' => 'long'],
        'no_useless_else' => true,
        'no_useless_return' => true,
        'ordered_class_elements' => true,
        'ordered_imports' => true,
        'php_unit_strict' => true,
        'return_type_declaration' => true,
        'simplified_null_return' => false,
        'void_return' => true,
        'phpdoc_order' => true,
        'semicolon_after_instruction' => true,
        'strict_comparison' => true,
        'strict_param' => true,
        'phpdoc_align' => false,
        'declare_strict_types' => true,
    ])
    ->setFinder($finder)
    ;
