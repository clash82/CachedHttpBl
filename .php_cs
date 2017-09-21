<?php

return PhpCsFixer\Config::create()
    ->setRules([
        'concat_space' => ['spacing' => 'none'],
        'array_syntax' => false,
        'simplified_null_return' => false,
        'phpdoc_align' => false,
        'phpdoc_separation' => false,
        'phpdoc_to_comment' => false,
        'cast_spaces' => ['space' => 'single'],
        'blank_line_after_opening_tag' => false,
        'phpdoc_no_alias_tag' => false,
    ])
    ->setRiskyAllowed(true)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__)
            ->exclude([
                'vendor',
            ])
            ->files()->name('*.php')
    )
;
