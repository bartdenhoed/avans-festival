<?php

/**
 * Problem controller contains all error pages
 */
class Problem extends Controller
{
    /**
     * Default redirect to error 404 page
     */
    public function index()
    {
        header('location: ' . URL . 'problem/error404');exit;
    }

    /**
     * Echo error code
     */
    public function error404()
    {
        header('HTTP/1.0 404 Not Found', true, 404);
        echo 'error 404';
    }
}
