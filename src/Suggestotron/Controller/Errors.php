<?php
namespace Suggestotron\Controller;

class Errors extends \Suggestotron\Controller {
    
    public function indexAction($options)
    {
        header("HTTP/1.0 404 Not Found");
        $this->render("/errors/index.phtml", ['message' => "Page not found!" ]);
    }
    
    public function editAction($options)
        {
            header("HTTP/1.0 404 Not Found");
            $this->render("/errors/topic.phtml");
        }
}
