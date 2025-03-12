<?php

namespace Controllers;

class Controller
{
    public function view($viewPath, $data = []) : void
    {        
        //extract variables to be used in the view
        extract($data);

        //default head
        require_once __DIR__ . '/../views/components/head.php';

        //default header
        require_once __DIR__ . '/../views/components/header.php';

        //check if the view exists
        if (file_exists(__DIR__ . '/../views/' . $viewPath . '.php')) {
            require_once __DIR__ . '/../views/' . $viewPath . '.php';
        } else {
            $this->fourOFour();
        }

        //default footer
        require_once __DIR__ . '/../views/components/footer.php';
    }

    public function view_clean($viewPath, $data = []) : void
    {
        //extract variables to be used in the view
        extract($data);

        //check if the view exists
        if (file_exists(__DIR__ . '/../views/' . $viewPath . '.php')) {
            require_once __DIR__ . '/../views/' . $viewPath . '.php';
        } else {
            $this->fourOFour();
        }
    }

    public function fourOFour() : void
    {
        $this->view('404/index');
    }
}