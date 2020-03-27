<?php
// me: /transaction/model/Transaction.php
require_once(PACKAGE_DIR . '/core/exception/ErrorHandler.php');
require_once(PACKAGE_DIR . '/transaction/model/ProductTypeEnum.php');
require_once(PACKAGE_DIR . '/transaction/model/TransactionEndpointEnum.php');
require_once(PACKAGE_DIR . '/fraudandbucketsengine/model/FraudAndBucketsConfig.php');

/**
 * @author jtezva 2020/03/27
 * Model and Builder for a transaction, including fraud and buckets config, and wallet buckets amount
 */
class Transaction {
    
    public /* ProductTypeEnum */ $productType;
    public /* string          */ $paymentMethod;
    public /* boolean         */ $isMixedUsingWallet;
    public /* boolean         */ $isCorporate;

    public /* TransactionEndpointEnum */ $originEndpoint;
    public /* TransactionEndpointEnum */ $targetEndpoint;
    public /* FraudAndBucketsConfig   */ $fraudAndBucketsConfig;

    public /* float */ $realAmount;
    public /* float */ $safeAmount;
    public /* float */ $riskyAmount;
    public /* float */ $promoAmount;
    public /* float */ $refundableAmount;

    /**
     * Default constructor to initialize values
     */
    public function __construct() {
        $this->isMixedUsingWallet = false;
        $this->isCorporate = false;
        $this->realAmount = 0;
        $this->safeAmount = 0;
        $this->riskyAmount = 0;
        $this->promoAmount = 0;
        $this->refundableAmount = 0;
    }

    /**
     * Build the transaction and load the fraud and buckets engine config
     * @param productType the product to buy/pay (ProductTypeEnum)
     * @param paymentMethod the payment method (currently not used)
     * @param originEndpoint the origin of the transaction (TransactionEndpointEnum)
     * @param isMixedUsingWallet indicaes if its mixed using wallet
     * @param isCorporate indicates if its corporate
     * @throws UndosTresException when transaction is invalid or from internal validations
     * @return instance of Transaction (this)
     */
    public static function build(string $productType, string $paymentMethod, string $originEndpoint, bool $isMixedUsingWallet,
            $isCorporate) {
        $transaction = null;
        try {
            ProductTypeEnum::validate($productType);
            TransactionEndpointEnum::validate($originEndpoint);

            $transaction = new Transaction();
            $transaction->productType = $productType;
            $transaction->paymentMethod = $paymentMethod;
            $transaction->isMixedUsingWallet = $isMixedUsingWallet;
            $transaction->isCorporate = $isCorporate;

            $transaction->originEndpoint = $originEndpoint;
            $targetEndpoint = ProductTypeEnum::getEquivalentTransactionEndpoint($productType);
            $transaction->targetEndpoint = $targetEndpoint;

            $transaction->fraudAndBucketsConfig = FraudAndBucketsConfig::build($originEndpoint, $targetEndpoint,
                    $isMixedUsingWallet, $isCorporate);
        } catch (Exception $e) {
            ErrorHandler::raise('Building Transaction', $e);
        }
        return $transaction;
    }
}
?>