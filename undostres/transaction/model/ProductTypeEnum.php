<?php
// me: /transaction/model/ProductTypeEnum.php
require_once(PACKAGE_DIR . '/core/exception/ErrorHandler.php');
require_once(PACKAGE_DIR . '/transaction/model/TransactionEndpointEnum.php');

/**
 * @author jtezva 2020/03/27
 * Enum for the Product Types
 */
class ProductTypeEnum {

    // all the product types
    const AGUA          = "agua";
    const CASH_CASHOUT  = "cash_cashout"; // <<< not real
    const CELULAR       = "celular";
    const CINE          = "cine";
    const CREDIT        = "creditline";
    const ENTERTAINMENT = "entertainment";
    const GAS           = "gas";
    const GOB           = "gob";
    const HIPOTECA      = "hipoteca";
    const LUZ           = "luz";
    const MULTINIVELES  = "multiniveles";
    const PARKIMETRO    = "parkimetro";
    const POSTPAGO      = "postpago";
    const PRESTAMO      = "prestamo";
    const P2P           = "p2p";
    const QRMERCHANT    = "qrmerchant";
    const RECARGA       = "regarga";
    const STP_CASHOUT   = "stp_cashout"; // <<< not real
    const TAG           = "tag";
    const TELEFONO      = "telefono";
    const TELEVISION    = "television";
    const TRANSPORT     = "transport";
    const VIP           = "vip";
    const WALLET        = "wallet";

    // all the product types as array
    public const TYPES = array(
        ProductTypeEnum::AGUA,
        ProductTypeEnum::CASH_CASHOUT,
        ProductTypeEnum::CELULAR,
        ProductTypeEnum::CINE,
        ProductTypeEnum::CREDIT,
        ProductTypeEnum::ENTERTAINMENT,
        ProductTypeEnum::GAS,
        ProductTypeEnum::GOB,
        ProductTypeEnum::HIPOTECA,
        ProductTypeEnum::LUZ,
        ProductTypeEnum::MULTINIVELES,
        ProductTypeEnum::PARKIMETRO,
        ProductTypeEnum::POSTPAGO,
        ProductTypeEnum::PRESTAMO,
        ProductTypeEnum::P2P,
        ProductTypeEnum::QRMERCHANT,
        ProductTypeEnum::RECARGA,
        ProductTypeEnum::STP_CASHOUT,
        ProductTypeEnum::TAG,
        ProductTypeEnum::TELEFONO,
        ProductTypeEnum::TELEVISION,
        ProductTypeEnum::TRANSPORT,
        ProductTypeEnum::VIP,
        ProductTypeEnum::WALLET
    );

    // equivalences between product types and transaction endpoints
    public const EQUIVALENCES = array(
        ProductTypeEnum::AGUA          => TransactionEndpointEnum::FULFILLMENT,
        ProductTypeEnum::CASH_CASHOUT  => TransactionEndpointEnum::CASH,
        ProductTypeEnum::CELULAR       => TransactionEndpointEnum::FULFILLMENT,
        ProductTypeEnum::CINE          => TransactionEndpointEnum::FULFILLMENT,
        ProductTypeEnum::CREDIT        => TransactionEndpointEnum::CREDIT,
        ProductTypeEnum::ENTERTAINMENT => TransactionEndpointEnum::FULFILLMENT,
        ProductTypeEnum::GAS           => TransactionEndpointEnum::FULFILLMENT,
        ProductTypeEnum::GOB           => TransactionEndpointEnum::FULFILLMENT,
        ProductTypeEnum::HIPOTECA      => TransactionEndpointEnum::FULFILLMENT,
        ProductTypeEnum::LUZ           => TransactionEndpointEnum::FULFILLMENT,
        ProductTypeEnum::MULTINIVELES  => TransactionEndpointEnum::FULFILLMENT,
        ProductTypeEnum::PARKIMETRO    => TransactionEndpointEnum::FULFILLMENT,
        ProductTypeEnum::POSTPAGO      => TransactionEndpointEnum::FULFILLMENT,
        ProductTypeEnum::PRESTAMO      => TransactionEndpointEnum::MY_WALLET,
        ProductTypeEnum::P2P           => TransactionEndpointEnum::FRIEND_WALLET,
        ProductTypeEnum::QRMERCHANT    => TransactionEndpointEnum::FRIEND_WALLET,
        ProductTypeEnum::RECARGA       => TransactionEndpointEnum::FULFILLMENT,
        ProductTypeEnum::STP_CASHOUT   => TransactionEndpointEnum::SPEI,
        ProductTypeEnum::TAG           => TransactionEndpointEnum::FULFILLMENT,
        ProductTypeEnum::TELEFONO      => TransactionEndpointEnum::FULFILLMENT,
        ProductTypeEnum::TELEVISION    => TransactionEndpointEnum::FULFILLMENT,
        ProductTypeEnum::TRANSPORT     => TransactionEndpointEnum::FULFILLMENT,
        ProductTypeEnum::VIP           => TransactionEndpointEnum::VIP,
        ProductTypeEnum::WALLET        => TransactionEndpointEnum::MY_WALLET
    );

    private function __construct() {}

    /**
     * Check if the product type exists
     * @param type to search in ::TYPES
     * @return boolean if it exists or not
     */
    public static function isValid(string $type) {
        return $type && in_array($type, ProductTypeEnum::TYPES);
    }

    /**
     * Check if the product type exists
     * @param type to search in ::TYPES
     * @throws UnDosTresException if it doesnt exists
     */
    public static function validate(string $type) {
        $isValid = ProductTypeEnum::isValid($type);
        if (!$isValid) {
            ErrorHandler::exception("Invalid Product Type '$type'");
        }
    }

    /**
     * Get the Equivalent TransactionEndpoint for a Product Type
     * @param type the product type you want to transform to transaction endpoint
     * @return endpoint the equivalent transaction endpoint
     * @throws UnDosTresException when the product type is invalid or doesnt have an equivalent
     */
    public static function getEquivalentTransactionEndpoint(string $type) {
        $endpoint = null;
        ProductTypeEnum::validate($type);
        if (!isset(ProductTypeEnum::EQUIVALENCES[$type])) {
            ErrorHandler::exception("The Product Type '$type' doesnt have an equivalent transaction endpoint");
        }
        $endpoint = ProductTypeEnum::EQUIVALENCES[$type];
        return $endpoint;
    }
}
?>