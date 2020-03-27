<?php
require_once(PACKAGE_DIR . '/core/exception/UnDosTresException.php');

/**
 * @author jtezva 2020/03/27
 * With this class you manage and generate exceptions
 */
class ErrorHandler {

    private function __construct() {}

    /**
     * Throws a new UnDosTresException
     * @param message for the exception
     * @throws UnDosTresException
     */
    public static function exception(string $message) {
        throw new UnDosTresException($message, 500, null);
    }

    /**
     * Throws a new UnDosTresException using code
     * @param message for the exception
     * @param code for the exception
     * @throws UnDosTresException
     */
    public static function exceptionWithCode(string $message, int $code) {
        throw new UnDosTresException($message, $code, null);
    }

    /**
     * Checks if the exception is unexpected and throws a new UnDosTresException with the message.
     * If the exception is already an UnDosTresException then it just re-throws it.
     * This should be callet always on middle layers, never on the top layer so the exception cant escape.
     * For the top layer there is the method ::handle()
     * @param message A message indicating the process: "Saving data", "Loading Wallet", "Calling API"...
     * @param exception The Exception than can be UnDosTresException or any other
     * @throws UnDosTresException the same as exception if its UndosTresException, or a new using "message"
     */
    public static function raise(string $message, Exception $exception) {
        if ($exception instanceof UnDosTresException) {
            throw $exception;
        } else {
            if ($message) {
                throw new UnDosTresException('Error in the process: ' . strtolower($message), 500, $exception);
            } else {
                throw new UnDosTresException('Unexpected system error', 500, $exception);
            }
        }
    }

    /**
     * Checks for an exception and format the correct message. If the exception is UnDosTresException means that
     * it was already formatted, in other case it was unexpected. This method wont let the exception escape, and it
     * should be called only in the top layer. For other layers there is the method ::raise()
     */
    public static function handle(string $message, Exception $exception) {
        $errorDescription = null;
        if ($exception instanceof UnDosTresException) {
            logg(str_replace(PHP_EOL, '<br/>', $exception->getTraceAsString()));
            $errorDescription = $exception->getMessage();
        } else {
            try {
                ErrorHandler::raise($message, $exception);
            } catch (Exception $unDosTresException) {
                $errorDescription = ErrorHandler::handle($message, $unDosTresException);
            }
        }
        return $errorDescription;
    }
}
?>