<?php
namespace Suggestotron\Controller;

class Topics extends \Suggestotron\Controller {
    protected $data;

    public function __construct()
    {
        parent::__construct();
        $this->data = new \Suggestotron\Model\Topics();
    }

    public function listAction($options) {
        $topics = $this->data->getAllTopics();
        $this->render("index/list.phtml", ['topics' => $topics]);
    }

    public function addAction($options) {
        if ( isset($_POST) && sizeof($_POST) > 0 )
        {
            $this->data->add($_POST);
            header("location: /");
            exit;
        }

        $this->render("index/add.phtml");
    }

    public function editAction($options) {
        if ( isset($_POST['id']) && !empty($_POST['id']) ) {
            if ( $this->data->update($_POST) ) {
                header("location: /");
                exit;
            } else {
                $this->render("errors/topic.phtml", ["message" => "Update failed!"]);
                exit;
            }
        }

        if ( !isset($options['id']) || empty($options['id']) ) {
            $this->render("errors/topic.phtml", ["message" => "No ID was found!"]);
            exit;
        }

        $topic = $this->data->getTopic($options['id']);

        if ( $topic === false ){
            $this->render("errors/topic.phtml", ["message" => "Topic not found"]);
            exit;
        }

        $this->render("index/edit.phtml", ['topic' => $topic]);
    }

    public function deleteAction($options) {
        if ( !isset($options['id']) || empty($options['id']) ) {
            $this->render("errors/topic.phtml", ["message" => "No ID was found!"]);
            exit;
        }

        $topic = $this->data->getTopic($options['id']);

        if ( $topic === false ){
            $this->render("errors/topic.phtml", ["message" => " Topic not found!"]);
            exit;
        }

        if ( $this->data->delete($options['id']) ) {
            header("location: /");
            exit;
        } else {
            $this->render("errors/topic.phtml", ["message" => "An error occurred!"]);
            exit;
        }

    }
    
    public function aboutAction($options){
        $this->render("index/about.phtml");
    }

}