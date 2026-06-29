<?php

class ProjectController
{
    public function index(): void
    {
        $model    = new ProjectModel();
        $projects = $model->getAllPublished();
        $stats    = $model->getHeroStats();

        $content = BASE_PATH . '/views/proiecte/index.php';
        require BASE_PATH . '/views/layouts/main.php';
    }
}
