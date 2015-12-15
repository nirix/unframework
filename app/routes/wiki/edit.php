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
            $slug = isset($data['slug']) ? $data['slug'] : false;
            $content = isset($data['content']) ? $data['content'] : false;
        }

        if (empty($name) || empty($slug) || empty($content)) {
            return render('wiki/edit.phtml', ['page' => $page, 'error' => true]);
        } else {
            $query = db()->prepare("
                UPDATE pages
                SET name = :name, slug = :slug, content = :content
                WHERE id = :id
                LIMIT 1
            ");
            $query->bindValue(':name', $name, PDO::PARAM_STR);
            $query->bindValue(':content', $content, PDO::PARAM_STR);
            $query->bindValue(':slug', $slug, PDO::PARAM_STR);
            $query->bindValue(':id', $page['id'], PDO::PARAM_INT);
            $query->execute();

            return redirect("/wiki/{$slug}");
        }
    }
} else {
    return show404();
}
