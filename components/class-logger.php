<?php
/**
 * Logger
 */

namespace theme_plugin\components;

use Exception;

class Logger
{
    public static string $logPath = '';

    private function __construct()
    {
    }

    /**
     * Writes log data to file
     *
     * @param  mixed  $data
     * @param  bool  $detail  - use var_dump instead var_export
     *
     * @throws Exception
     */
    public static function log(...$data): void
    {
        self::checkLogPath();
        $record = '['.date('d.m.Y H:i:s').'] Log data: '.PHP_EOL
            .self::prepareData(...$data).PHP_EOL;
        file_put_contents(self::$logPath, $record, FILE_APPEND);
    }

    /**
     * @throws Exception
     */
    private static function checkLogPath()
    {
        if (empty(self::$logPath)) {
            throw new Exception('Empty logPath');
        }
    }

    /**
     * Returns prepared data
     *
     * @param $data
     * @param  false  $detail  - use var_dump instead var_export
     *
     * @return false|string|true
     */
    private static function prepareData(...$data)
    {
        $detail = false;
        if ($detail) {
            ob_start();
            var_dump($data);
            $record = ob_get_clean();
        } else {
            ob_start();
            var_export($data);
            $record = ob_get_clean();
        }
        return rtrim($record);
    }

    /**
     * Writes log data to browser console
     *
     * @param $data
     * @param  null  $group  - header of console group
     * @param  false  $detail  - use var_dump instead var_export
     */
    public static function console($data, $group = null, $detail = false)
    {
        $record = json_encode(self::prepareData($data, $detail));
        $groupPrefix = $groupPostfix = null;
        if ($group) {
            $groupPrefix = 'console.groupCollapsed("'.$group.'");';
            $groupPostfix = 'console.groupEnd();';
        }
        echo <<< EOT
            <script>
                $groupPrefix console.log($record) $groupPostfix
            </script>    
EOT;
    }

    /**
     * Writes log data to pre tag
     *
     * @param $data
     * @param  false  $detail  - use var_dump instead var_export
     */
    public static function pre(...$data)
    {
        $record = self::prepareData($data);
        echo <<< EOT
            <pre>$record</pre>
EOT;
    }

    /**
     * Writes backtrace to file
     *
     * @throws Exception
     */
    public static function traceToLog()
    {
        self::checkLogPath();
        $record = '['.date('d.m.Y H:i:s').'] Backtrace data: '.PHP_EOL.self::trace();
        file_put_contents(self::$logPath, $record, FILE_APPEND);
    }

    /**
     * Returns backtrace data
     *
     * @return string
     */
    private static function trace(): string
    {
        $record = '';
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        foreach ($backtrace as $key => $el) {
            if ($key > 0) {
                $record .= '#'.$key.' '.$el['class'].$el['type'].$el['function']
                    .'() called at ['.$el['file'].':'.$el['line'].']'.PHP_EOL;
            }
        }
        return $record;
    }

    /**
     * Writes backtrace to browser console
     *
     * @param  null  $group
     */
    public static function traceToConsole($group = null)
    {
        $record = json_encode(self::trace());
        $groupPrefix = $groupPostfix = null;
        if ($group) {
            $groupPrefix = 'console.groupCollapsed("'.$group.'");';
            $groupPostfix = 'console.groupEnd();';
        }
        echo <<< EOT
            <script>
                $groupPrefix console.log($record) $groupPostfix
            </script>    
EOT;
    }

    /**
     * Writes backtrace to pre tag
     */
    public static function traceToPre()
    {
        $record = self::trace();
        echo <<< EOT
            <pre>$record</pre>
EOT;
    }

    private function __clone()
    {
    }
}
