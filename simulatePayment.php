<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('libraries.php');
require_once(PACKAGE_DIR . '/transaction/model/ProductTypeEnum.php');

$mode = 'front';

if (isset($_GET) && isset($_GET['action'])) {
    $mode = 'back';
}

if ($mode === 'back') {
    require('simulateBack.php');
} else {?>
<form method="GET">
  <fieldset>
    <legend>Payment</legend>
    <table>
      <tr>
        <td>Product Type:</td>
        <td>
          <select name="productType">
            <option value="">-Select-</option>
            <?php
            foreach (ProductTypeEnum::TYPES as $pt) {
                echo "<option value=\"$pt\">$pt</option>";
            }
            ?>
          </select>
        </td>
      </tr>
      <tr>
        <td>Payment Method:</td>
        <td>
          <select name="paymentMethod">
            <option value="">-Select-</option>
            <option value="MY_WALLET">Wallet</option>
            <option value="CREDIT">Credit</option>
            <option value="CASH">Cash</option>
            <option value="SPEI">Spei</option>
            <option value="CARD">Card</option>
            <option value="PAYPAL">Paypal</option>
          </select>
        </td>
      </tr>
      <tr>
        <td colspan="2">
            <label><input type="checkbox" value="1" name="isMixed"/>Is Mixed?</label></br/>
            <label><input type="checkbox" value="1" name="isCorporate"/>Is Corporate?</label>
        </td>
      </tr>
      <tr>
        <td>Method amount:</td>
        <td><input type="number" name="methodAmount"/></td>
      </tr>
      <tr>
        <td>Wallet amount (when mixed):</td>
        <td><input type="number" name="walletAmount"/></td>
      </tr>
      <tr>
        <td colspan="2"><input type="hidden" name="action"/><input type="submit"/></td>
      </tr>
    </table>
  </fieldset>
</form>
<?php
}
?>