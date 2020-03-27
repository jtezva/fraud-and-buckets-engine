<?php
// me: /fraudandbucketsengine/model/FraudEngineStrategyEnum.php
require_once(PACKAGE_DIR . '/core/exception/ErrorHandler.php');

/**
 * @author jtezva 2020/03/27
 * Enum for the Fraud Engine Strategies, that tell us when to run the fraud engine
 */
class FraudEngineStrategyEnum {

    // all strategies
    const NEVER = 'NEVER';
    const WHEN_RISKY = 'WHEN_RISKY';
    const WHEN_RISKY_OR_PROMO = 'WHEN_RISKY_OR_PROMO';
    const ALWAYS = 'ALWAYS';

    // all strategies as array
    const STRATEGIES = array(
        FraudEngineStrategyEnum::NEVER,
        FraudEngineStrategyEnum::WHEN_RISKY,
        FraudEngineStrategyEnum::WHEN_RISKY_OR_PROMO,
        FraudEngineStrategyEnum::ALWAYS
    );

    private function __construct() {}

    /**
     * Verify if the strategy exists
     * @param strategy to search in ::STRATEGIES
     * @return boolean if it exists or not
     */
    public static function isValid($strategy) {
        return $strategy && in_array($strategy, FraudEngineStrategyEnum::STRATEGIES);
    }

    /**
     * Check if the strategy exists
     * @param strategy to search in ::STRATEGIES
     * @throws UnDosTresException if it doesnt exists
     */
    public static function validate(string $strategy) {
        $valid = FraudEngineStrategyEnum::isValid($strategy);
        if (!$valid) {
            ErrorHandler::exception("Invalid Fraud Engine Strategy '$strategy'");
        }
    }
}
?>