<?php
namespace AtlasWong\LaravelJobStatusViewer;

use Imtigger\LaravelJobStatus\JobStatus;

/**
 * Class LaravelJobStatusViewer
 * @package AtlasWong\LaravelJobStatusViewer
 */
class LaravelJobStatusViewer
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
        self::$type = $type;
    }
    
    /**
     * @return array
     */
    public static function all()
    {
        $job_statuses = [];
        
        if (isset(self::$type) && !empty(self::$type)) {
            $job_statuses = JobStatus::where('type', self::$type)->orderBy('status', 'asc')->orderBy('updated_at', 'desc')->get()->toArray();
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

        return array_values($job_statuses);
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
        // create new job instance
        // dispatch with params
        if (class_exists(self::$type)) {
            dispatch(new self::$type($input));
            return [];
        } else {
            return [];
        }
    }
}
