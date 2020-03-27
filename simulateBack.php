<?php
require_once(PACKAGE_DIR . '/core/exception/ErrorHandler.php');
require_once(PACKAGE_DIR . '/transaction/model/Transaction.php');

function logg(string $message) {
    echo "<p>$message";
}

function getFromGet(string $key, bool $strict) {
    $value = null;
    if (isset($_GET[$key]) && $_GET[$key]) {
        $value = $_GET[$key];
    } else if ($strict) {
        ErrorHandler::exception("Missing '$key'");
    }
    return $value;
}

try {
    // data validation
    $productType = getFromGet('productType', true);
    $paymentMethod = getFromGet('paymentMethod', true);
    $isMixed = getFromGet('isMixed', false) == "1";
    $isCorporate = getFromGet('isCorporate', false) == "1";
    $methodAmount = (float) getFromGet('methodAmount', true);
    $walletAmount = getFromGet('walletAmount', false);
    $walletAmount = $walletAmount ? ((float) $walletAmount) : 0;
    logg("productType: $productType, " .
            "paymentMethod: $paymentMethod, " .
            "isMixed: " . ($isMixed ? "true" : "false") . ", " .
            "isCorporate: " . ($isCorporate ? "true" : "false") . ", " .
            "methodAmount: $methodAmount, " .
            "walletAmount: $walletAmount"
    );

    if ($methodAmount <= 0) {
        ErrorHandler::exception("Amount is negative!");
    }

    if ($isMixed && $walletAmount <= 0)  {
        ErrorHandler::exception("Invalid wallet amount for mixed!");
    }

    $bucketAndFraudFeatureActive = true; // get from Beta Active
    $transaction = null;
    if ($bucketAndFraudFeatureActive) {
        $transaction = Transaction::build($productType, $paymentMethod, $paymentMethod, $isMixed, $isCorporate);
        logg('transaction: ' . json_encode($transaction));
    }

    // insert siftfrauddata
    logg('-INSERT INTO SIFTFRAUDDATA-');

} catch (Exception $e) {
    $message = ErrorHandler::handle("Doing payment", $e);
    echo "<p>ERROR: $message";
    die();
}
?>