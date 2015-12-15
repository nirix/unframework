<?php
$slug = Request::$properties->get('slug') ?: 'index';

$page = db()->prepare("SELECT * FROM pages WHERE slug = :slug LIMIT 1");
$page->bindParam(':slug', $slug, \PDO::PARAM_STR);
$page->execute();

$page = $page->fetch(\PDO::FETCH_ASSOC);

if ($page) {
    if (Request::$properties->get('extension') == 'json') {
        return json($page);
    } else {
        return render('wiki/show.phtml', ['page' => $page]);
    }
} else {
    return show404();
}
