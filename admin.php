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

    <div id="admin" class="page">
          
        <h1>ACCOUNTS OVERVIEW</h1>
        <?php 

            foreach ( $jInnerData as $jClientId => $jClient ) {
                // TERNARY: if true '?' unblock and if not block
                $sWord = ($jClient->active == 0) ? 'UNBLOCK' : 'BLOCK';
                $totalBalance = $jClient->totalBalance->balance;
                echo "<div class='client'>
                <div>ID: $jClientId</div>
                <div>Full name: $jClient->name $jClient->lastName</div>
                <div>Email: $jClient->email</div>
                <div>Balance: $totalBalance</div>
                <div>Status: $jClient->active</div>
                <br>
                <a href='apis/api-block-user-account?id=$jClientId'>$sWord</a>
                <br>
                <br>
                </div>";

            }
            ?>  
        <br>
        <br>
        <form id="frmAdminTransfer" action="apis/api-admin-transfer" method="POST">
            <h2>Transfer money to any account</h2>
            <input name="phone" type="tel" placeholder="phone">
            <br>
            <input name="amount" type="number" placeholder="amount">
            <br>
            <button>Transfer money</button>
        </form>
        </div>

        </div>

       
   
        
  
<?php 
  require_once 'bottom.php'; 
  ?>
  <script>
   $('#admin').show()
</script>