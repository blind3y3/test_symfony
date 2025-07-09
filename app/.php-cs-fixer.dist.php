<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
    ->notPath('src/DataKeeper/OrderStatus.php')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'global_namespace_import' => ['import_classes' => true],
    ])
    ->setFinder($finder)
;
