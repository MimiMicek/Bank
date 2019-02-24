<?php
require_once 'top.php';

ini_set('display_errors', 0);

session_start();

$sUserId = $_SESSION['sUserId'];

$sData = file_get_contents('data/clients.json');
$jData = json_decode($sData);
if($jData == null){ echo 'System update'; }
$jInnerData = $jData->data;
$jClient = $jInnerData->$sUserId;
?>
<style>
  td{
    text-align: center;
  }
  thead{
    font-weight: bold;
  }
</style>
<div id="create-credit-card" class="page">
  <h1>CREATE CREDIT CARD</h1>
  <br>
  <form id="frmCreateCard">
    <input id="txtCreateCardName" name="txtCreateCardName" placeholder="Visa . . ." type="text" required>
    <br>
    <br>
    <button>Create credit card</button>
  </form>
  <br>
  <br>
  <h1>Credit cards</h1>
  <br>
  <br>
  <table>
    <thead>
        <tr>
          <td width="20%">CARD NAME</td>
          <td width="20%">CREDIT LIMIT</td>
          <td width="20%">ACTIVE</td>
          <td width="20%">SET STATUS</td>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach($jClient->creditCards as $sCreditCardId => $creditCard){
            $sWord = ($creditCard->active == 0) ? 'UNBLOCK' : 'BLOCK';
            echo "
              <tr>
                <td>$creditCard->name</td>
                <td>$creditCard->creditLimit</td>
                <td>$creditCard->active</td>
                <td><a href='apis/api-block-or-unblock-credit-card?id=$sCreditCardId'>$sWord</a></td>
              </tr>
            ";
          }?>
      </tbody>
  </table>
  
</div>

<?php 
require_once 'bottom.php'; 
?>
<script>
   $('#create-credit-card').show()
</script>
<script src="js/credit-card.js"></script>