<form method="post">
	<input type="text" id="msg">
	<input type="button" id="btn" value="Send">
</form>

<div id="msg_box"></div>

<script src="https://code.jquery.com/jquery-3.6.0.js" ></script>
<script>
var conn = new WebSocket('ws://localhost:8080');
console.log(conn);
conn.onopen = function(e) {
    console.log("Connection established!");
   
};

conn.onmessage = function(e) {
	var getData=jQuery.parseJSON(e.data);
    var html="<b>Test: </b>: "+getData.msg+"<br/>";
	jQuery('#msg_box').append(html);
};

jQuery('#btn').click(function(){
	var msg=jQuery('#msg').val();
	var content={
		msg:msg,
	};
	conn.send(JSON.stringify(content));
	
	var html="<b>Test: </b>: "+msg+"<br/>";
	jQuery('#msg_box').append(html);
	jQuery('#msg').val('');

	jQuery.ajax({
		type: 'post',
		url: 'http://127.0.0.1/PHPWebSocketsChatRoom/',
		data: { 
			action:'onMessage',
			msg:msg,
		},
		dataType : 'json',
		success: function (response) {
			console.log(response)
			
		},
		error : function(errorThrown){
			console.log(errorThrown);
		}
	});
});
</script>
