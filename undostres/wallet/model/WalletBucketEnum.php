<?php
// me: /wallet/model/WalletBucketEnum.php
require_once(PACKAGE_DIR . '/core/exception/ErrorHandler.php');

/**
 * @author jtezva 2020/03/27
 * Enum for the Wallet Buckets
 */
class WalletBucketEnum {

    // all buckets
    const SAFE = 'SAFE';
    const RISKY = 'RISKY';
    const PROMO = 'PROMO';
    const REFUNDABLE ='REFUNDABLE';
    const REAL_ = 'REAL_';

    // all buckets as array
    const BUCKETS = array(
        WalletBucketEnum::SAFE,
        WalletBucketEnum::RISKY,
        WalletBucketEnum::PROMO,
        WalletBucketEnum::REFUNDABLE,
        WalletBucketEnum::REAL_
    );

    private function __construct() {}

    /**
     * Check if the bucket exists
     * @param bucket to search in ::BUCKETS
     * @return boolean if it exists or not
     */
    public static function isValid(string $bucket) {
        return $bucket && in_array($bucket, WalletBucketEnum::BUCKETS);
    }

    /**
     * Check if the bucket exists
     * @param bucket to search in ::BUCKETS
     * @throws UnDosTresException if it doesnt exists
     */
    public function validate(string $bucket) {
        if (!WalletBucketEnum::isValid($bucket)) {
            ErrorHandler::exception("Invalid Wallet Bucket '$bucket'");
        }
    }
}
?>