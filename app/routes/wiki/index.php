<?php
$query = db()->query("SELECT name, slug FROM pages ORDER BY name ASC");
$pages = $query->fetchAll(PDO::FETCH_ASSOC);

if (Request::$properties->get('extension') == 'json') {
    return json($pages);
} else {
    return render('wiki/index.phtml', ['pages' => $pages]);
}
