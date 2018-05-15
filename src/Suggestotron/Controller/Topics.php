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
                echo "An error occurred";
                exit;
            }
        }

        if ( !isset($options['id']) || empty($options['id']) ) {
            echo "You did not pass in an ID";
            exit;
        }

        $topic = $this->data->getTopic($options['id']);

        if ( $topic === false ){
            echo "Topic not found!";
            exit;
        }

        $this->render("index/edit.phtml", ['topic' => $topic]);
    }

    public function deleteAction($options) {
        if ( !isset($options['id']) || empty($options['id']) ) {
            echo "You did not pass in an ID";
            exit;
        }

        $topic = $this->data->getTopic($options['id']);

        if ( $topic === false ){
            echo "Topic not found!";
            exit;
        }

        if ( $this->data->delete($options['id']) ) {
            header("location: /");
            exit;
        } else {
            echo "An error occurred";
            exit;
        }

    }

}