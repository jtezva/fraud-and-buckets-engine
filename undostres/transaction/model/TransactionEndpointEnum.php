<?php
// me: /transaction/model/TransactionEndpointEnum.php
require_once(PACKAGE_DIR . '/core/exception/ErrorHandler.php');

/**
 * @author jtezva 2020/03/27
 * Enum for the Transaction Endpoints
 */
class TransactionEndpointEnum {

    // all endpoints
    const MY_WALLET     = 'MY_WALLET';
    const FRIEND_WALLET = 'FRIEND_WALLET';
    const CREDIT        = 'CREDIT';
    const CASH          = 'CASH';
    const SPEI          = 'SPEI';
    const CARD          = 'CARD';
    const PAYPAL        = 'PAYPAL';
    const FULFILLMENT   = 'FULFILLMENT';
    const VIP           = 'VIP';
    
    // all endpoints as array
    const ENDPOINTS = array(
        TransactionEndpointEnum::MY_WALLET,
        TransactionEndpointEnum::FRIEND_WALLET,
        TransactionEndpointEnum::CREDIT,
        TransactionEndpointEnum::CASH,
        TransactionEndpointEnum::SPEI,
        TransactionEndpointEnum::CARD,
        TransactionEndpointEnum::PAYPAL,
        TransactionEndpointEnum::FULFILLMENT,
        TransactionEndpointEnum::VIP
    );

    private function __construct() {}

    /**
     * Check if the endpoint exists
     * @param endpoint to search in ::ENDPOINTS
     * @return boolean if it exists or not
     */
    public static function isValid(string $endpoint) {
        return $endpoint && in_array($endpoint, TransactionEndpointEnum::ENDPOINTS);
    }

    /**
     * Check if the endpoint exists
     * @param endpoint to search in ::ENDPOINTS
     * @throws UnDosTresException if it doesnt exists
     */
    public static function validate(string $endpoint) {
        $isValid = TransactionEndpointEnum::isValid($endpoint);
        if (!$isValid) {
            ErrorHandler::exception("Invalid Transaction Endpoint '$endpoint'");
        }
    }
}
?>