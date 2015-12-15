<?php
$data = Request::$post->get('wiki');

if (Request::$method === 'POST') {
    if (empty($data['name']) || empty($data['slug']) || empty($data['content'])) {
        return render('wiki/new.phtml', ['page' => $data, 'error' => true]);
    } else {
        $query = db()->prepare("
            INSERT INTO pages
            (name, slug, content)
            VALUES(:name, :slug, :content)
        ");

        $query->bindValue(':name', $data['name'], PDO::PARAM_STR);
        $query->bindValue(':slug', $data['slug'], PDO::PARAM_STR);
        $query->bindValue(':content', $data['content'], PDO::PARAM_STR);

        $query->execute();

        return redirect("/wiki/{$data['slug']}");
    }
} else {
    return render('wiki/new.phtml', ['page' => $data]);
}
