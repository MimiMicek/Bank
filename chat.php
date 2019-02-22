<?php
require_once 'top.php';

session_start();

if(!isset($_SESSION['sUserId'])){
  header('Location: login');
}

$sUserId = $_SESSION['sUserId'];

$sData = file_get_contents('data/clients.json');
$jData = json_decode($sData);
if($jData == null){ echo 'System update'; }
$jInnerData = $jData->data;
$jClient = $jInnerData->$sUserId;
?>

<style>
    body{ 
      display: grid; 
      justify-items: center; 
      align-items: center;  
      width: 100vw; 
      height: 100vh; 
      overflow: hidden;
      font-size: 40px;
    }
    body > div{
      position: relative;
      width: 500px;
      height: 500px;
      border: 2px solid black;
      padding: 20px;
    }
    form{
      position: absolute;
      bottom: 20px;
    }
    #chat{
      color: black;
    }
  </style>
</head>
<body>

  <div id="chat">
    <div id="lblMessages">
      <strong>Simple chat</strong>
    </div>
    <form id="#frmChat">
      <input name="txt-user-id" type="text" placeholder="Enter number for chat">
      <input name="txt-message" type="text" placeholder="Type . . .">
      <button>Send</button>
    </form>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  
  <script>

    let sUserId = '<?= $sUserId; ?>'

    $('form').submit( function(){
      $.ajax({
        method: "POST",
        url: "apis/api-set-message",
        data: $('form').serialize(),
        cache: false
      }).
      done(function( sMessages ){
        sMessages = sMessages.replace(':)', '😀' )
        console.log('done')
      }).
      fail(function(){

      })
      return false;
    })

    setInterval( function(){

      $.ajax({
        method: "GET",
        url: "apis/api-get-message?sUserId="+sUserId,
        cache: false
      }).
      done(function( sMessages ){
        $('#lblMessages').append('<div>'+sMessages+'</div>')
      }).
      fail(function(){
        console.log('Chat fails')
      })
    } , 1000 )
  
  </script>
<?php 
require_once 'bottom.php'; 
?>
<script>
   $('#chat').show()
</script>
