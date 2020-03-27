<?php
// me: /fraudandbucketsengine/model/FraudAndBucketsEnginePolicies.php
require_once(PACKAGE_DIR . '/transaction/model/TransactionEndpointEnum.php');
require_once(PACKAGE_DIR . '/fraudandbucketsengine/model/FraudEngineStrategyEnum.php');
require_once(PACKAGE_DIR . '/fraudandbucketsengine/model/FraudAndBucketsPropertyEnum.php');
require_once(PACKAGE_DIR . '/fraudandbucketsengine/model/BucketsStrategyEnum.php');
require_once(PACKAGE_DIR . '/wallet/model/WalletBucketEnum.php');
require_once(PACKAGE_DIR . '/core/constant/Constant.php');

/**
 * @author jtezva 2020/03/27
 * Configuration for the system transactions, for each transaction:
 * 
 * BUCKET_STRATEGY          => How to take the money out from a wallet
 * BUCKET_TARGET            => Destination bucket to put the money in
 * CORPORATE_FRAUD_STRATEGY => When to run the fraud engine if the transaction is corporate
 * MIXED_FRAUD_STRATEGY     => When to run the fraud engine if the transaction is not corporate but is mixed
 * DEFAULT_FRAUD_STRATEGY   => When to run the fraud engine if the transaction is not corporate nor mixed
 * 
 * The 2-dimension array has as the first index the ORIGIN of the transaction.
 * The second index is the TARGET of the transaction:
 * 
 * WALLET =>
 *     SPEI => (strategies),
 *     FULFILLMENT => (strategies)
 *     VIP => (strategies)
 * CREDIT =>
 *     SPEI...
 * ...
 */
class FraudAndBucketsEnginePolicies {
    
    const POLICIES = array(

        ///////////////////////
        // ORIGIN: MY_WALLET //
        TransactionEndpointEnum::MY_WALLET => array(

            // => FRIEND_WALLET (P2P from wallet)
            TransactionEndpointEnum::FRIEND_WALLET => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => BucketsStrategyEnum::SAFE_RISKY,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => null,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::WHEN_RISKY,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => Constant::INVALID,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),

            // => CREDIT (pay credit with wallet)
            TransactionEndpointEnum::CREDIT => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => BucketsStrategyEnum::SAFE_RISKY,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => null,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::WHEN_RISKY,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => Constant::INVALID,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),

            // => SPEI (cashout from wallet)
            TransactionEndpointEnum::SPEI => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => BucketsStrategyEnum::SAFE_RISKY,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => null,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::WHEN_RISKY,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => Constant::INVALID,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),

            // => FULFILLMENT (from wallet)
            TransactionEndpointEnum::FULFILLMENT => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => BucketsStrategyEnum::SAFE_RISKY_PROMO,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => null,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::WHEN_RISKY_OR_PROMO,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => Constant::INVALID,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),

            // => VIP (pay vip with wallet)
            TransactionEndpointEnum::VIP => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => BucketsStrategyEnum::SAFE_RISKY,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => null,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::WHEN_RISKY,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => Constant::INVALID,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            )
        ),
        // END OF WALLET //
        ///////////////////

        ////////////////////
        // ORIGIN: CREDIT //
        TransactionEndpointEnum::CREDIT => array(

            // => MY_WALLET (topup from credit)
            TransactionEndpointEnum::MY_WALLET => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => WalletBucketEnum::RISKY,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => Constant::INVALID,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),
            
            // => FRIEND_WALLET (P2P with credit)
            TransactionEndpointEnum::FRIEND_WALLET => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => WalletBucketEnum::RISKY,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),
            
            // => SPEI (cashout from credit)
            TransactionEndpointEnum::SPEI => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => null,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),
            
            // => FULFILLMENT (with credit)
            TransactionEndpointEnum::FULFILLMENT => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => null,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),
            
            // => VIP (pay vip with credit)
            TransactionEndpointEnum::VIP => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => null,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            )
        ),
        // END OF CREDIT //
        ///////////////////

        //////////////////
        // ORIGIN: CASH //
        TransactionEndpointEnum::CASH => array(

            // => MY_WALLET (cash-in)
            TransactionEndpointEnum::MY_WALLET => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => WalletBucketEnum::SAFE,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::NEVER,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => Constant::INVALID,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),
            
            // => FRIEND_WALLET (P2P with cash)
            TransactionEndpointEnum::FRIEND_WALLET => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => WalletBucketEnum::SAFE,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::NEVER,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => FraudEngineStrategyEnum::WHEN_RISKY,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),
            
            // => CREDIT (pay credit with cash)
            TransactionEndpointEnum::CREDIT => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => null,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::NEVER,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => FraudEngineStrategyEnum::WHEN_RISKY,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),
            
            // => FULFILLMENT (with cash)
            TransactionEndpointEnum::FULFILLMENT => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => null,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::NEVER,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => FraudEngineStrategyEnum::WHEN_RISKY_OR_PROMO,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),
            
            // => VIP (pay vip with cash)
            TransactionEndpointEnum::VIP => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => null,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::NEVER,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => FraudEngineStrategyEnum::WHEN_RISKY,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            )
        ),
        // END OF CASH //
        /////////////////

        //////////////////
        // ORIGIN: SPEI //
        TransactionEndpointEnum::SPEI => array(

            // => MY_WALLET (cash-in from spei)
            TransactionEndpointEnum::MY_WALLET => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => WalletBucketEnum::SAFE,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::NEVER,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => Constant::INVALID,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),
            
            // => FRIEND_WALLET (P2P with spei)
            TransactionEndpointEnum::FRIEND_WALLET => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => WalletBucketEnum::SAFE,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::NEVER,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => FraudEngineStrategyEnum::WHEN_RISKY,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),
            
            // => CREDIT (pay credit with spei)
            TransactionEndpointEnum::CREDIT => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => null,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::NEVER,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => FraudEngineStrategyEnum::WHEN_RISKY,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),
            
            // => FULFILLMENT (with spei)
            TransactionEndpointEnum::FULFILLMENT => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => null,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::NEVER,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => FraudEngineStrategyEnum::WHEN_RISKY_OR_PROMO,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),
            
            // => VIP (pay vip with spei)
            TransactionEndpointEnum::VIP => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => null,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::NEVER,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => FraudEngineStrategyEnum::WHEN_RISKY,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            )
            ),
        // END OF SPEI //
        /////////////////

        //////////////////
        // ORIGIN: CARD //
        TransactionEndpointEnum::CARD => array(

            // => MY_WALLET (cash-in from card)
            TransactionEndpointEnum::MY_WALLET => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => WalletBucketEnum::RISKY,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => Constant::INVALID,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),
            
            // => FRIEND_WALLET (P2P with card)
            TransactionEndpointEnum::FRIEND_WALLET => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => WalletBucketEnum::RISKY,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),
            
            // => CREDIT (pay credit with card)
            TransactionEndpointEnum::CREDIT => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => null,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),
            
            // => FULFILLMENT (with card)
            TransactionEndpointEnum::FULFILLMENT => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => null,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),
            
            // => VIP (pay vip with card)
            TransactionEndpointEnum::VIP => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => null,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            )
        ),
        // END OF CARD //
        /////////////////

        ////////////////////
        // ORIGIN: PAYPAL //
        TransactionEndpointEnum::PAYPAL => array(

            // => MY_WALLET (cash-in from paypal)
            TransactionEndpointEnum::MY_WALLET => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => WalletBucketEnum::RISKY,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => Constant::INVALID,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),
            
            // => FRIEND_WALLET (P2P with paypal)
            TransactionEndpointEnum::FRIEND_WALLET => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => WalletBucketEnum::RISKY,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),
            
            // => CREDIT (pay credit with paypal)
            TransactionEndpointEnum::CREDIT => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => null,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),
            
            // => FULFILLMENT (with paypal)
            TransactionEndpointEnum::FULFILLMENT => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => null,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            ),
            
            // => VIP (pay vip with paypal)
            TransactionEndpointEnum::VIP => array(
                FraudAndBucketsPropertyEnum::BUCKETS_STRATEGY => null,
                FraudAndBucketsPropertyEnum::BUCKET_TARGET    => null,
                
                FraudAndBucketsPropertyEnum::DEFAULT_FRAUD_STRATEGY   => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::MIXED_FRAUD_STRATEGY     => FraudEngineStrategyEnum::ALWAYS,
                FraudAndBucketsPropertyEnum::CORPORATE_FRAUD_STRATEGY => FraudEngineStrategyEnum::NEVER
            )
        )
        // END OF PAYPAL //
        ///////////////////
    );

    private function __construct() {}
}
?>