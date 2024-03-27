<?php

namespace application\controllers;

use application\core\Controller;
use application\models\Landing;

/**
 * @property Landing model
 */
class LandingController extends Controller
{

    public function indexAction()
    {
        $this->view->layout = 'simple';
        $this->view->settings = $this->model->getSettings();
        $this->view->title = $this->view->settings['title'];
        $this->view->infoblocks = $this->model->getInfoblocks();
        $this->view->banners = $this->model->getBanners();
        $this->view->buttons = $this->model->getButtons();
        $this->view->render();
    }

}