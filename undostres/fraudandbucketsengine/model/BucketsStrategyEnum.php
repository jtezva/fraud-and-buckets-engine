<?php
// me: /fraudandbucketsengine/model/BucketsStrategyEnum.php
require_once(PACKAGE_DIR . '/core/exception/ErrorHandler.php');

/**
 * @author jtezva 2020/03/27
 * Enum for the Wallet Buckets Strategies, that are the possible ways to take money out from a wallet
 */
class BucketsStrategyEnum {

    // all strategies
    const SAFE_RISKY = 'SAFE,RISKY';
    const SAFE_RISKY_PROMO = 'SAFE,RISKY,PROMO';

    // all strategies as array
    const STRATEGIES = array(
        BucketsStrategyEnum::SAFE_RISKY,
        BucketsStrategyEnum::SAFE_RISKY_PROMO
    );

    private function __construct() {}

    /**
     * Check if the strategy exists
     * @param strategy to search in ::STRATEGIES
     * @return boolean if it exists or not
     */
    public static function isValid(string $strategy) {
        return $strategy && in_array($strategy, BucketsStrategyEnum::STRATEGIES);
    }

    /**
     * Check if the strategy exists
     * @param strategy to search in ::STRATEGIES
     * @throws UnDosTresException if it doesnt exists
     */
    public static function validate(string $strategy) {
        $valid = BucketsStrategyEnum::isValid($strategy);
        if (!$valid) {
            ErrorHandler::exception("Invalid Buckets Strategy '$strategy'");
        }
    }
}
?>