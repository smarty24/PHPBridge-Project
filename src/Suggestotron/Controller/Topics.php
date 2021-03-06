<?php
namespace Suggestotron\Controller;
session_start();

class Topics extends \Suggestotron\Controller {
    protected $data;

    public function __construct()
    {
        parent::__construct();
        $this->data = new \Suggestotron\Model\Topics();
    }

    public function listAction($options)
    {
        $topics = $this->data->getAllTopics();
        $this->render("index/list.phtml", ['topics' => $topics]);
    }

    public function addAction($options)
    {
        if ( isset($_POST) && sizeof($_POST) > 0)
        {
            if ( empty($_POST['title']) )
            {
                $_SESSION['error'] = "Title field must not be blank."; //add error messages to session variables
                $_SESSION['title'] = $_POST['title'];
                $_SESSION['description'] = $_POST['description'];
                header("Location: /topic/add/"); //redirect back to the same page
                exit;
            }
            else if ( empty($_POST['description']) )
            {
                $_SESSION['error'] = "Description field must not be blank."; //add error messages to session variables
                $_SESSION['title'] = $_POST['title'];
                $_SESSION['description'] = $_POST['description'];
                header("Location: /topic/add/"); //redirect back to the same page
                exit;
            }
            else
            {
                $this->data->add($_POST);
                //set flash message for successful added topic
                $_SESSION['success'] = "Topic added successfully.";
                header("location: /");
                exit;
            }
        }

        $this->render("index/add.phtml");
    }

    public function editAction($options) {
        if ( isset($_POST['id']) && !empty($_POST['id']) ) {
            if ( empty($_POST['title'])  || empty($_POST['description']) )
            {
                $_SESSION['error'] = "Fields must not be empty.";
                header("Location: /topic/edit/{$_POST['id']}");
                exit;
            }
            else {
                $this->data->update($_POST);
                $_SESSION['success'] = "Topic changed successfully.";
                header("Location: /");
                exit;
            }
        }

        if ( !isset($options['id']) || empty($options['id']) )
        {
            header("HTTP/1.0 404 Not Found");
            $this->render("errors/topic.phtml", ["message" => "ID was not found!"]);
            exit;
        }

        $topic = $this->data->getTopic($options['id']);

        if ( $topic === false ){
            header("HTTP/1.0 404 Not Found");
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
            $_SESSION['success'] = "Topic deleted successfully.";
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