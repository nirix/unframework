<?php

use Unf\HTTP\Request;

/**
 * Get the database connection.
 *
 * @return PDO
 */
function db()
{
    return $GLOBALS['db'];
}

/**
 * Render a view and wrap it in a response.
 *
 * @param  string $view
 * @param  array  $locals
 *
 * @return string
 */
function render($view, array $locals = [])
{
    $locals = $locals + [
        '_layout' => 'default.phtml'
    ];

    $content = View::render($view, $locals);

    if (isset($locals['_layout']) && $locals['_layout']) {
        $content = View::render("layouts/{$locals['_layout']}", [
            'content' => $content
        ]);
    }

    return $content;
}

/**
 * Set JSON headers and convert content to JSON is needed.
 *
 * @param mixed $content
 */
function json($content)
{
    header('Content-Type: application/json');

    if (is_array($content)) {
        echo json_encode($content);
    } elseif (is_string($content)) {
        echo $content;
    }
}

/**
 * Render a 404 page.
 *
 * @return string
 */
function show404()
{
    return render('errors/404.phtml');
}

/**
 * Redirect to the specified path.
 *
 * @param string $path
 */
function redirect($path)
{
    header("Location: " . Request::$basePath . "/index.php{$path}");
    exit;
}
