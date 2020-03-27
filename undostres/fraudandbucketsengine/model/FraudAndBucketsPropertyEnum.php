<?php
// me: /fraudandbucketsengine/model/FraudAndBucketsPropertyEnum.php

/**
 * @author jtezva 2020/03/27
 * Enum of properties for the fraud and buckets policies
 */
class FraudAndBucketsPropertyEnum {
    
    const BUCKETS_STRATEGY = "BUCKETS_STRATEGY";
    const BUCKET_TARGET    = "BUCKET_TARGET";
    const CORPORATE_FRAUD_STRATEGY = "CORPORATE_FRAUD_POLICY";
    const MIXED_FRAUD_STRATEGY     = "MIXED_WITH_WALLET_FRAUD_POLICY";
    const DEFAULT_FRAUD_STRATEGY   = "DEFAULT_FRAUD_STRATEGY";

    private function __construct() {}
}
?>