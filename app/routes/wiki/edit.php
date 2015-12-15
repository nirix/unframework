<?php
$page = db()->prepare("SELECT * FROM pages WHERE slug = :slug LIMIT 1");
$page->bindValue(':slug', Request::$properties->get('slug'), \PDO::PARAM_STR);
$page->execute();

$page = $page->fetch(\PDO::FETCH_ASSOC);

if ($page) {
    if (Request::$method === 'GET') {
        return render('wiki/edit.phtml', ['page' => $page]);
    } elseif (Request::$method === 'POST') {

        if ($data = Request::$post->get('wiki')) {
            $name = isset($data['name']) ? $data['name'] : false;
            $content = isset($data['content']) ? $data['content'] : false;
        }

        if (empty($name) || empty($content)) {
            return render('wiki/edit.phtml', ['page' => $page, 'error' => true]);
        } else {
            $query = db()->prepare("UPDATE pages SET name = :name, content = :content WHERE slug = :slug LIMIT 1");
            $query->bindValue(':name', $name);
            $query->bindValue(':content', $content);
            $query->bindValue(':slug', $page['slug']);
            $query->execute();

            return redirect("/wiki/{$page['slug']}");
        }
    }
} else {
    return show404();
}
