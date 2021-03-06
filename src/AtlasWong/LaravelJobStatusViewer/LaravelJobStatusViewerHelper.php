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
     * @param array|object|null $type
     */
    public static function setType($type)
    {
        self::$type = $type['type']??$type->type??null;
    }
    
    /**
     * @return array
     */
    public static function all()
    {
        $job_statuses = [];
        
        if (isset(self::$type) && !empty(self::$type)) {
            $job_statuses = JobStatus::where('type', self::$type)->orderBy('status', 'desc')->orderBy('updated_at', 'desc')->get()->toArray();
        } else {
            $job_statuses = JobStatus::orderBy('status', 'desc')->orderBy('updated_at', 'desc')->get()->toArray();
        }
        
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
        return config('laravel-log-viewer');
    }
    
    /**
     * @return array
     */
    public static function requeue($id)
    {
        $input = JobStatus::find($id)->input??null;
        $class = JobStatus::find($id)->type??null;
        // create new job instance
        // dispatch with params
        if (class_exists($class)) {
            dispatch(new $class($input));
            return [];
        } else {
            return [];
        }
    }
}
