var lastId = 0;
$(".shoutbox-shouts").html('');


function addShout(data) {
	$(".shoutbox-shouts").append(
		'<tr>' +
			'<td>'+ data.username +'</td>' +
			'<td>'+ data.content.replace(/(<([^>]+)>)/ig,"") +'</td>' +
		'</tr>'
	).hide().fadeIn();
}

$("#shoutbox-form").submit(function(event) {
	event.preventDefault();
	var content = $("#shout-content").val();
	$("#shout-content").val('');
	var Username = username;
	addShout({ username: Username, content: content });
	$.ajax({
		url: "/api/shout",
		type: "POST",
		data: { content: content },
		success: function() {
			lastId++;
		},
		error: function() {

		}
	});
});

$.get("/api/shout", function(data) {
	lastId = data[data.length - 1].id;
	for(i = 0; i < data.length; i++) {
		$(".shoutbox-shouts").append(
			'<tr>' +
				'<td>'+ data[i].username +'</td>' +
				'<td>'+ data[i].content.replace(/(<([^>]+)>)/ig,"") +'</td>' +
			'</tr>'
		);
	}
});

window.setInterval(function() {
	$.get("/api/shout", function(data) {
		for(i = 0; i < data.length; i++) {
			if(data[i].id > lastId)
			{
				$(".shoutbox-shouts").append(
					'<tr>' +
						'<td>'+ data[i].username +'</td>' +
						'<td>'+ data[i].content +'</td>' +
					'</tr>'
				);
			}
		}
		lastId = data[data.length - 1].id;
	});

	while($(".shoutbox-shouts").find("tr").length > 15)
	{
		$(".shoutbox-shouts").find("tr:first").fadeOut().remove();
	}
}, 1400);