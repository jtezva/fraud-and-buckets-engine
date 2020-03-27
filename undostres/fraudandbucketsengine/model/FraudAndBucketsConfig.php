<?php
// me: /fraudandbucketsengine/model/FraudAndBucketsConfig.php
require_once(PACKAGE_DIR . '/core/exception/ErrorHandler.php');
require_once(PACKAGE_DIR . '/transaction/model/TransactionEndpointEnum.php');
require_once(PACKAGE_DIR . '/fraudandbucketsengine/model/FraudAndBucketsEnginePolicies.php');
require_once(PACKAGE_DIR . '/fraudandbucketsengine/model/FraudAndBucketsPropertyEnum.php');
require_once(PACKAGE_DIR . '/core/constant/Constant.php');

/**
 * @author jtezva 2020/03/27
 * Model and Builder for the Fraud and Buckets Engine configuration
 */
class FraudAndBucketsConfig {

    public /* TransactionEndpointEnum */ $originEndpoint;
    public /* TransactionEndpointEnum */ $targetEndpoint;

    public /* boolean */ $isMixedUsingWallet;
    public /* boolean */ $isCorporate;

    public /* BucketsStrategyEnum */ $bucketsStrategy;
    public /* WalletBucketEnum    */ $bucketTarget;

    public /* FraudEngineStrategyEnum */ $fraudEngineStrategy;

    public /* FraudAndBucketsConfig */ $configForMixedCase;

    public function __construct() {}

    /**
     * Builder that loads the configuration from FrandAndBucketsEnginePolicies
     * @param originEndpoint the origin of the transaction (TransactionEndpointEnum)
     * @param targetEndpoint the target of the transaction (TransactionEndpointEnum)
     * @param isMixedUsingWallet indicaes if its mixed using wallet
     * @param isCorporate indicates if its corporate
     * @throws UnDosTresException from internal validations
     * @return instance of FrandAndBucketsConfig (this)
     */
    public static function build(string $originEndpoint, string $targetEndpoint, bool $isMixedUsingWallet,
            bool $isCorporate) {
        $config = null;
        try {
            // validating endpoints
            TransactionEndpointEnum::validate($originEndpoint);
            TransactionEndpointEnum::validate($targetEndpoint);

            // validating policy
            if (!isset(FraudAndBucketsEnginePolicies::POLICIES[$originEndpoint]) ||
                    !isset(FraudAndBucketsEnginePolicies::POLICIES[$originEndpoint][$targetEndpoint])) {
                ErrorHandler::exception("Fraud And Buckets Engine Policy from '$originEndpoint' to '$targetEndpoint' " .
                        "is invalid");
            }
            $policy = FraudAndBucketsEnginePolicies::POLICIES[$originEndpoint][$targetEndpoint];

            // instatiating the config object
            $config = new FraudAndBucketsConfig();
            $config->originEndpoint = $originEndpoint;
            $config->targetEndpoint = $targetEndpoint;
            $config->isMixedUsingWallet = $isMixedUsingWallet;
            $config->isCorporate = $isCorporate;

            // buckets strategy & bucket target
            if (isset($policy[FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY]) &&
                    $policy[FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY]) {
                $config->bucketsStrategy = $policy[FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY];
            }
            if (isset($policy[FraudAndBucketsPropertyEnum::BUCKET_TARGET]) &&
                    $policy[FraudAndBucketsPropertyEnum::BUCKET_TARGET]) {
                $config->bucketTarget = $policy[FraudAndBucketsPropertyEnum::BUCKET_TARGET];
            }

            if ($isMixedUsingWallet) {
                $mixedPolicy = $policy[FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY];
                if (!$mixedPolicy || $mixedPolicy == Constant::INVALID) {
                    ErrorHandler::exception("Transaction from '$originEndpoint' to '$targetEndpoint' can not be mixed");
                }
                if ($isCorporate) {
                    $config->fraudEngineStrategy = $policy[FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY];
                } else {
                    $config->fraudEngineStrategy = $policy[FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY];
                }

                // load config for the mixed buckets strategy
                $config->configForMixedCase = FraudAndBucketsConfig::build(TransactionEndpointEnum::MY_WALLET,
                        $targetEndpoint, false, false);
            } else { // no mixed
                if ($isCorporate) {
                    $config->fraudEngineStrategy = $policy[FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY];
                } else {
                    $config->fraudEngineStrategy = $policy[FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY];
                }
            }
        } catch (Exception $e) {
            ErrorHandler::raise('Building fraud and buckets config', $e);
        }
        return $config;
    }
}
?>