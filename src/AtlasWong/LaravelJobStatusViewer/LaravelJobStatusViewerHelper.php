<?php
namespace AtlasWong\LaravelJobStatusViewer;

use App\Jobs\LazadaManifestApiRequest;
use Imtigger\LaravelJobStatus\JobStatus;

/**
 * Class LaravelJobStatusViewer
 * @package AtlasWong\LaravelJobStatusViewer\LaravelJobStatusViewer
 */
class LaravelJobStatusViewerHelper
{
    /**
     * @var string $type
     */
    private static $type;
    
    /**
     * @param string $type
     */
    public static function setType($type)
    {
        if (!empty($type)) {
            $type = json_decode($type, true);
        }
        self::$type = $type['type']??$type->type??null;
    }
    
    /**
     * @return array
     */
    public static function all()
    {
        if (isset(self::$type) && !empty(self::$type)) {
            $job_statuses = JobStatus::where('type', self::$type)->orderBy('status', 'desc')->orderBy('updated_at', 'desc')->get()->toArray();
        } else {
            $job_statuses = JobStatus::orderBy('status', 'desc')->orderBy('updated_at', 'desc')->get()->toArray();
        }
    
        // TODO: customized ordering by status
        $pa = ['failed' => 1, 'executing' => 2, 'queued' => 3, 'finished' => 4];
        $custom_sort = true;
        
        return $job_statuses;
    }
    
    
    /**
     * @param bool $basename
     * @return array
     */
    public static function getTypes()
    {
        $job_statuses = JobStatus::distinct()->get(['type']);

        return $job_statuses;
    }

    /**
     * @return string
     */
    public static function getTypeName()
    {
        return self::$type;
    }
    
    /**
     * @return array
     */
    public static function getConfigs()
    {
        return config('laravel-job-status-viewer');
    }
    
    /**
     * @return array
     */
    public static function requeue($id)
    {
        $entity = JobStatus::find($id);
        $input = $entity->input??null;
        $class = $entity->type??null;
        // create new job instance
        // dispatch with params
        if (class_exists($class)) {
            dispatch(new $class(json_decode($input, true)));
            $entity->status = 'finished';
            $entity->save();
        } else {
            return ['success' => false, 'message' => 'Job Class not find'];
        }
    }
}
