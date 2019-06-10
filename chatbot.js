 var me = {};
me.avatar = "me.png";

var you = {};
you.avatarsvt = "you.png";

function formatAMPM(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}            

 $(function () {
    window.initialMessageDisplayed = false;
	var date = formatAMPM(new Date());
    $(document).mouseenter(function(){
        if(!window.initialMessageDisplayed){
            var obj = JSON.parse($("#dom-target").text());
			var displayDate = '<p><small>'+date+'</small></p>';
			var event = obj.result.action;
            var answerdiv = jQuery('<div/>', {
                html: obj.result.fulfillment.speech.linkify()+'&nbsp;',
                'class': "rounded-div-bot",
                tabindex:1
            });
			var displayDate = "<div class='rounded-div-bot'><small>" + date + "</small></div>";
			answerdiv.append(displayDate);
			var displayPerson = "<div class='avatarsvt'><img class='img-circle' style='width:100%;' src=" + you.avatarsvt +" /></div><br/><br/>";
			var lineBreak = "<br/><br/><br/>";
			$("#chat-text" ).append(displayPerson);
            $("#chat-text").append(answerdiv);
			$("#chat-text" ).append(lineBreak);
            $("#message").focus();
            window.initialMessageDisplayed = true;
        }
    });
 
 
    var guid = ($("#sessionId").text()).trim();
 
 
    $('form').on('submit', function (e) {
        var query = $("#message").val();
        try{
            sendGAEvent('iFrame', guid, 'userSays: '+query);
        }
        catch(e){
            console.log(e);
        }
 
        showUserText();
        e.preventDefault();
 
 
        $.ajax({
            type: 'post',
            url: 'process.php',
            data: {submit:true, message:query, sessionid: guid},
            success: function (response) {
                var obj = JSON.parse(response);
                var event = obj.result.action;
                var answerdiv = jQuery('<div/>', {
                    html: obj.result.fulfillment.speech.linkify()+'&nbsp;',
                    'class': "rounded-div-bot",
                    tabindex:1
                });
				
				var displayDate = "<div class='rounded-div-bot'><small>" + date + "</small></div>";
				answerdiv.append(displayDate);
				var displayPerson = "<div class='avatarsvt'><img class='img-circle' style='width:100%;' src=" + you.avatarsvt +" /></div><br/><br/><br/>";
				var lineBreak = "<br/><br/><br/>";
				$("#chat-text" ).append(displayPerson);
                $("#chat-text").append(answerdiv);
				$("#chat-text" ).append(lineBreak);
				 if(event){
                    var stylingDiv = jQuery('<div/>', {
                        html: $("#template").html(),
                        tabindex:1
                    });
                    if(event === 'show.customizer'){
                        $(answerdiv).append(stylingDiv);
                    }
                }
                $(answerdiv).focus();
                $("#message").focus();
                try{
                    sendGAEvent('iFrame',guid,'botSays: '+obj.result.fulfillment.speech)
                }
                catch(e){
                    console.log(e);
                }
            }
        });
 
    });
 
});
 
function sendGAEvent(category, action, label){
   
}
 
function showUserText(){
    var div = jQuery('<div/>', {
        text: $("#message").val(),
        'class': "rounded-div",
        tabindex:1
    });
	var date = formatAMPM(new Date());
	var displayDate = "<div class='rounded-div'><small>" + date + "</small></div>";
	div.append(displayDate);
	var displayPerson = "<div class='avatar'><img class='img-circle' style='width:100%;' src=" + me.avatar +" /></div><br/><br/><br/>";
	var lineBreak = "<br/><br/><br/>";
	$("#chat-text" ).append(displayPerson);
	$("#chat-text" ).append(div);
	$("#chat-text" ).append(lineBreak);
	$("#message").val('');
}
 
if(!String.linkify) {
    String.prototype.linkify = function() {
 
        // http://, https://, ftp://
        var urlPattern = /\b(?:https?|ftp):\/\/[a-z0-9-+&@#\/%?=~_|!:,.;]*[a-z0-9-+&@#\/%=~_|]/gim;
 
        // www. sans http:// or https://
        var pseudoUrlPattern = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
 
        // Email addresses
        var emailAddressPattern = /[\w.]+@[a-zA-Z_-]+?(?:\.[a-zA-Z]{2,6})+/gim;
 
        return this
            .replace(urlPattern,
                '<a class="answerLink" style="color:white;font-weight:bold" target="_blank" href="$&">click here</a>')
            .replace(pseudoUrlPattern,
                '$1<a class="answerLink" style="color:white;font-weight:bold" target="_blank" href="http://$2">click here</a>')
            .replace(emailAddressPattern,
                '<a class="answerLink" style="color:white;font-weight:bold" href="mailto:$&">click here</a>');
    };
}