<?php
class DatabaseLogger {

    function __construct() {
        App::import('Model', 'Log');
        $this->Log = new Log;
    }

    function write($type, $message) {
        $log['type'] = ucfirst($type);
        $log['time'] = date('Y-m-d H:i:s');
        $log['message'] = $message;

        return $this->Log->save($log);
    }

}
?>