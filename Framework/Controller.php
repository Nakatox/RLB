<?php

namespace Framework;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Controller
{
    private $templating;

    public function __construct()
    {
        $loader = new FilesystemLoader('../App/View');
        $this->templating = new Environment($loader);
    }

    protected function renderTemplate(string $templateName, array $templateParameters = [])
    {
        echo $this->templating->render($templateName, $templateParameters);
    }
}