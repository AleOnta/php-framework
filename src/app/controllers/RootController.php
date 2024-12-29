<?php

namespace App\Controllers;

use App\Core\MySQL;
use App\Controller;
use App\MigrationRunner;
use App\Models\Request;

class RootController extends Controller
{
    private MigrationRunner $migrationManager;

    public function __construct(MigrationRunner $migrationRunner)
    {
        $this->migrationManager = $migrationRunner;
    }

    # default method that render the homepage
    public function index()
    {
        # define the content of the page
        $content = ['page_title' => 'Home', 'view' => 'index'];
        # define the assets required
        $assets = ['css' => ['global'], 'js' => ['index']];
        # render the page
        $this->render('basic', $content, $assets);
    }

    public function unauthorized()
    {
        # define the content of the page
        $content = ['page_title' => 'Unauthorized', 'view' => 'error'];
        # define the assets required
        $assets = ['css' => ['global'], 'js' => ['index']];
        # render the page
        $this->render('basic', $content, $assets);
    }

    public function migrations()
    {
        $data = $this->migrationManager->getMigrationsReport();
        # define the content of the page
        $content = ['page_title' => 'Unauthorized', 'view' => 'migrations', 'data' => $data];
        # define the assets required
        $assets = ['css' => ['global'], 'js' => ['index']];
        # render the page
        $this->render('basic', $content, $assets);
    }

    public function migrationsUp()
    {
        # validate custom request header
        $header = Request::getCustomHeader();
        if ($header === 'custom-run-migrations') {
            $this->migrationManager->migrate();
            $this->return(200, true, ['message' => 'OK']);
        }
        $this->return(400, false, ['message' => 'Wrong header in request.']);
    }
}
