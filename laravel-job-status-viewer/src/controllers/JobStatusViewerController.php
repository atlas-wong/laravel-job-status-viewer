<?php
namespace AtlasWong\LaravelJobStatusViewer;

if (class_exists("\\Illuminate\\Routing\\Controller")) {
    class BaseController extends \Illuminate\Routing\Controller {}
} else if (class_exists("Laravel\\Lumen\\Routing\\Controller")) {
    class BaseController extends \Laravel\Lumen\Routing\Controller {}
}

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class JobStatusViewerController extends BaseController
{

    public function index()
    {
        if (Request::input('l')) {
            LaravelJobStatusViewer::setType(base64_decode(Request::input('l')));
        }
    
        if (Request::input('rq')) {
            LaravelJobStatusViewer::requeue(base64_decode(Request::input('rq')));
            return $this->redirect(Request::url());
        }
        
        $job_statuses = LaravelJobStatusViewer::all();

        return View::make('laravel-job-status-viewer::status', [
            'job_status' => $job_statuses,
            'types' => LaravelJobStatusViewer::getTypes(),
            'current_type' => LaravelJobStatusViewer::getTypeName(),
            'config' => LaravelJobStatusViewer::getConfigs(),
        ]);
    }

    private function redirect($to)
    {
        if (function_exists('redirect')) {
            return redirect($to);
        }

        return Redirect::to($to);
    }
}
