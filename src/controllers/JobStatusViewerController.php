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
            LaravelJobStatusViewerHelper::setType(base64_decode(Request::input('l')));
        }
    
        if (Request::input('rq')) {
            $result = LaravelJobStatusViewerHelper::requeue(base64_decode(Request::input('rq')));
            return $this->redirect(Request::url());
        }
        
        $job_statuses = LaravelJobStatusViewerHelper::all();

//        return json_encode($result??$job_statuses);
        return View::make('laravel-job-status-viewer::status', [
            'job_statuses' => $job_statuses,
            'types' => LaravelJobStatusViewerHelper::getTypes(),
            'current_type' => LaravelJobStatusViewerHelper::getTypeName(),
            'config' => LaravelJobStatusViewerHelper::getConfigs(),
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
