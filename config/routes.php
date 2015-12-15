<?php
return [
    '/'                 => "routes/wiki/show.php",
    '/wiki'             => "routes/wiki/index.php",
    '/wiki/new'         => "routes/wiki/new.php",
    '/wiki/{slug}'      => "routes/wiki/show.php",
    '/wiki/{slug}/edit' => "routes/wiki/edit.php"
];
