# Custom pagination helper

Image you have 50 pages and you are on page 25. The page numbers would be shown like so:

1 | 2 .. 21 | 22 | 23 | 24 | 25 | 26 | 27 | 28 | 29 ..  49 | 50

Just call it like so:

    $myPaginator->numbers($options);

You can control the following options (listed are the default values):

    'tag' => 'span',
    'before'=> null,
    'after' => null,
    'modulus' => '8',
    'separator' => ' | ',
    'first' => null,
    'last' => null,
    'fold' => 0,
    'foldSep' => ' ... '
