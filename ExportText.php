<?
session_start();
require 'ValidateAdmin.php';
include_once $_SERVER['DOCUMENT_ROOT']."/../databaseinfo/database_info.php";


	$username = $_SESSION['username'];

	try {
			$conn = new PDO($WHMCS_DATABASE, $MYSQL_USER, $MYSQL_PASSWORD);
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage()."<br>";
			exit();
		}
	
	$time = time();
	$sql = 'Select username from tblhosting where domainstatus = "Active" and UNIX_TIMESTAMP(overidesuspenduntil) > :now order by username asc';
	$prep = $conn->prepare($sql);
	$prep->bindValue(':now',$time);
	$prep->execute();
	if($prep-rowCount > 0){
		foreach($prep as $p){
			if(!empty($p['username']) && $p['username'] != ""){
				$Users[] = $p['username'];
			}
		}
	}
	
?>
<head>
<style>
#ExportList{
	top: 0px;
	left: 700px;
	position: absolute;
}
#Loading
{ 
   height: 100px;
   width: 300px;
   position: absolute;
   left: 60%;
   top: 11%;
   margin: -25px 0 0 -25px;
   z-index: 100000;
}
#Loading2
{ 
   height: 100px;
   width: 300px;
   position: absolute;
   left: 60%;
   top: 17%;
   margin: -25px 0 0 -25px;
   z-index: 100000;
}
#Loading3
{ 
   height: 100px;
   width: 300px;
   position: absolute;
   left: 60%;
   top: 23%;
   margin: -25px 0 0 -25px;
   z-index: 100000;
}
#Loading4
{ 
   height: 100px;
   width: 300px;
   position: absolute;
   left: 60%;
   top: 28%;
   margin: -25px 0 0 -25px;
   z-index: 100000;
}
#Loading5
{ 
   height: 100px;
   width: 300px;
   position: absolute;
   left: 60%;
   top: 33%;
   margin: -25px 0 0 -25px;
   z-index: 100000;
}
#Loading6
{ 
   height: 100px;
   width: 300px;
   position: absolute;
   left: 60%;
   top: 39%;
   margin: -25px 0 0 -25px;
   z-index: 100000;
}
#SearchBox
{
	top: 45%;
	left: 43%;
	width: 40%;
	position: absolute;
	overflow-y:auto;
	height: 400px;
}
thead
{
  border-bottom: 1px solid black;
}
th
{
  padding:0 15px 0 15px;
}
tr:nth-child(odd) {
   background-color: #D0D0D0;
}
tr:hover
{
  background-color: #3399FF;
}
#div
{
	width: 1325px;
	height:615px;
	overflow-y: auto;
	margin: 0 auto;
}
th
{
	cursor: pointer;
}

</style>
<script src="/ThirdParty/jquery-1.10.1.js"></script>


<script type="text/javascript">
$(document).ready(function() {
	$('#Loading').fadeOut();
	$('#Loading2').fadeOut();
	$('#Loading3').fadeOut();
	$('#Loading4').fadeOut();
	$('#Loading5').fadeOut();
	$('#Loading6').fadeOut();
	$("#seluser").change(function () {
		var user = $(this).find("option:selected").val();
		$('#user').val(user);
		$.ajax({
		  type: "POST",
		  url: "GetUserBatches.php",
		  data: {user:user},
		  success:function(data) {
			 $('#batchlist').html(data); 
		  }
		});
	});
});
	
function sendInfo(){
	var ids = '';
	var count = 0;
	$('.batsel:checked').each(function() {
		ids = ids + ',' + $(this).val(); 
		count = count + 1;
	});
	ids = ids.substr(1);
	if(count > 0){
		$('#batchid').val(ids);
	}else{
		alert('No Batch Selected');
	}
	var Marked = 0;
	//Counts
	if($('#re3').is(':checked')){
		$('#Loading').fadeIn();
		Marked++;
	}
	if($('#re5').is(':checked')){
		$('#Loading2').fadeIn();
		Marked++;
	}
	if($('#re4').is(':checked')){
		$('#Loading3').fadeIn();
		Marked++;
	}
	if($('#re2').is(':checked')){
		$('#Loading4').fadeIn();
		Marked++;
	}
	if($('#re6').is(':checked')){
		$('#Loading5').fadeIn();
		Marked++;
	}
	if($('#re7').is(':checked')){
		$('#Loading6').fadeIn();
		Marked++;
	}
	//Ajax
	
	var Marked2 = 0;
	if($('#re3').is(':checked')){
		var batchid = $('#batchid').val();
		var username = $('#username').val();
		var Date = $('#Date').val();
		$.ajax({
			url:'/re/re3.php',
			type:'POST',
			data:{batchid:batchid,
				  username:username,
				  Date:Date},
			success: function(msg){
				Marked2++;
				$('#Loading').fadeOut();
				if(Marked == Marked2){
					DownloadZip();
				}
			}
		});
	}
	
	if($('#re5').is(':checked')){
		var batchid = $('#batchid').val();
		var username = $('#username').val();
		var Date = $('#Date').val();
		$.ajax({
			url:'/re/re5.php',
			type:'POST',
			data:{batchid:batchid,
				  username:username,
				  Date:Date},
			success: function(msg){
				Marked2++;
				$('#Loading2').fadeOut();
				if(Marked == Marked2){
					DownloadZip();
				}
			}
		});
	}
	if($('#re4').is(':checked')){
		var batchid = $('#batchid').val();
		var dsuser = $('#user').val();
		var username = $('#username').val();
		var Date = $('#Date').val();
		$.ajax({
			url:'/re/re4.php',
			type:'POST',
			data:{batchid:batchid,
				  dsuser:dsuser,
				  username:username,
				  Date:Date},
			success: function(msg){
				Marked2++;
				$('#Loading3').fadeOut();
				if(Marked == Marked2){
					DownloadZip();
				}
			}
		});
	}
	
	if($('#re2').is(':checked')){
		var batchid = $('#batchid').val();
		var username = $('#username').val();
		var Date = $('#Date').val();
		$.ajax({
			url:'/re/re2.php',
			type:'POST',
			data:{batchid:batchid,
				  username:username,
				  Date:Date},
			success: function(msg){
				Marked2++;
				$('#Loading4').fadeOut();
				if(Marked == Marked2){
					DownloadZip();
				}
			}
		});
	}
	
	if($('#re6').is(':checked')){
		var batchid = $('#batchid').val();
		var dsuser = $('#user').val();
		var username = $('#username').val();
		var Date = $('#Date').val();
		$.ajax({
			url:'/re/re6.php',
			type:'POST',
			data:{batchid:batchid,
				  dsuser:dsuser,
				  username:username,
				  Date:Date},
			success: function(msg){
				Marked2++;
				$('#Loading5').fadeOut();
				if(Marked == Marked2){
					DownloadZip();
				}
			}
		});
	}
	
	
	if($('#re7').is(':checked')){
	
		var batchid = $('#batchid').val();
		var username = $('#username').val();
		var Date = $('#Date').val();
		var count = $('#count').val();
		if(userInput == ""){
			alert("No user value picked.");
		}
		var inputArray = new Array();
		var num = new Array();
		for(var i=1; i<count; i++){
			if($('#userInput'+i).is(':checked')){
				var inputArray = $('$userInput'+i).val();
				var num = i;
			}
		}
	
		$.ajax({
			url:'/re/re7.php',
			type:'POST',
			data:{inputArray:inputArray,
				  num:num,
				  username:username,
				  Date:Date},
			success: function(msg){
				Marked2++;
				$('#Loading6').fadeOut();
				if(Marked == Marked2){
					DownloadZip();
				}
			}
		});
	}
}
$(document).ready(function(){

	function SearchAddress(){
		var ids = '';
		var count = 0;
		$('.batsel:checked').each(function() {
			ids = ids + ',' + $(this).val(); 
			count = count + 1;
		});
		ids = ids.substr(1);
		if(count > 0){
			$('#batchid').val(ids);
		}else{
			alert('No Batch Selected');
		}

		var batchid = $('#batchid').val();
		var user = $('#user').val();
		$.ajax({
			url:'SearchAddress.php',
			type:'POST',
			data:{batchid:batchid,
				  user:user},
			success: function(msg){
				$('#SearchBox').html(msg);
			}
		});
	}
	window.SearchAddress = SearchAddress;
});
function DownloadZip(){
	var Date = $('#Date').val();
	var username = $('#username').val();
	/*$.ajax({
		url: 'DownloadZip.php',
		type: 'POST',
		data: {Date:Date,
			   username:username},
		success: function(msg){
			//Do Nothing For Now
		}
	});*/
	window.location.href = '/re/DownloadZip.php?DateCheck="'+Date+'"';
}

</script>
</head>
<div id="SearchBox"></div>
<div id="Loading">
	<img src="/Images/pac-man.gif"> Prospect Financial
</div>
<div id="Loading2">
	<img src="/Images/pac-man.gif"> Prospect Ratings
</div>
<div id="Loading3">
	<img src="/Images/pac-man.gif"> Prospect Other Gifts
</div>
<div id="Loading4">
	<img src="/Images/pac-man.gif"> Attributes
</div>
<div id="Loading5">
	<img src="/Images/pac-man.gif"> Constituent Notepad
</div>
<div id="Loading6">
	<img src="/Images/pac-man.gif"> Profile Links
</div>
<body>
	<select name="user" Id ="seluser">
		<option value=" ">Select User</option>
		<?php
			foreach($Users as $User){
				echo "<option value ='".$User."'>".$User."</option>";
			}
		?>
	</select>
	<div id='batchlist' style='width:650px;height:550px;overflow:scroll'></div>
	<div id="ExportList">
		<h2>Export Type(s)</h2>
		<input type="checkbox" id="re3" name="re3" value="Prospect Financial">&nbsp; Prospect Financial<br><br>
		<input type="checkbox" id="re5" name="re5" value="Prospect Ratings">&nbsp; Prospect Ratings<br><br>
		<input type="checkbox" id="re4" name="re4" value="Prospect Other Gifts">&nbsp; Prospect Other Gifts<br><br>
		<input type="checkbox" id="re2" name="re2" value="Attributes">&nbsp; Attributes<br><br>
		<input type="checkbox" id="re6" name="re6" value="Constituent Notepad">&nbsp; Consituent Notepad<br><br>
		<input type="checkbox" id="re7" name="re7" value="Profile Links">&nbsp; Profile Links<br><br>
		<input type="button" id="search" name="search" onclick="javascript:SearchAddress();" value="Search"><br><br>
<?php	
		echo'<input type="hidden" id="Date" name="Date" value="'.Date("m-d-Y_H-i-s").'">';
		echo'<input type="hidden" id="username" name="username" value="'.$username.'">';

?>
	</div>
	<button type='button' id='subbatch' onclick='sendInfo()'>Submit</button> (Files take a while to download, please be patient)
	<!--<button type='button' id='DownloadZip' onclick='DownloadZip()'>Download Zip</button>-->
	<form id='subs' method='post' action='#'>
		<input type='hidden' id='batchid' name='batchid' value=''>
		<input type='hidden' id='user' name='user' value=''>
	</form>
</body>