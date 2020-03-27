<?php
/**
 * @author jtezva 2020/03/27
 * Application Exception to throw/raise when custom errors appears, managed by ErrorHandler.php
 */
class UnDosTresException extends Exception {
    
    /**
     * @param message whats happennig
     * @param code could be http or custom, default 500
     * @param exception when this class is a wrapper for a real runtime exception
     */
    public function __construct(string $message, int $code, $exception) {
        parent::__construct($message, $code, $exception);
    }
}
?>