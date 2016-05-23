var postId = 0;
var postBodyElement = null;

$('.post').find('.interaction').find('.edit').on('click', function(event) {
	event.preventDefault();

	postBodyElement = event.target.parentNode.parentNode.childNodes[1];
	var postBody = event.target.parentNode.parentNode.childNodes[1].textContent;
	// Get the postid in the article's data-postid
	postId = event.target.parentNode.parentNode.dataset.postid;
	$("#post-body").val(postBody);
	$('#edit-modal').modal();
});

$("#modal-save").on('click', function() {
	$.ajax({
		method: 'POST',
		url: urlEdit,
		data: {
			body: $('#post-body').val(),
			postId: postId,
			_token: token,
		}
	})
	.done(function (msg) {
		$(postBodyElement).text(msg.new_body);
		$('#edit-modal').modal('hide');
	});
});

$('.like').on('click', function(event) {
	event.preventDefault();
	// Get the postid in the article's data-postid
	postId = event.target.parentNode.parentNode.dataset.postid;
	console.log(postId);

	var isLike = event.target.previousElementSibling === null;
	console.log(isLike);
	$.ajax({
		method: 'POST',
		url: urlLike,
		data: {
			isLike: isLike,
			postId: postId,
			_token: token,
		}
	})
	.done(function() {
		event.target.innerText = isLike ?
			event.target.innerText == 'Like' ?'You like this post' : 'Like'
		: event.target.innerText == 'Dislike' ?
			'You don\'t like this post' : 'Dislike';

			// If I click the like link
			if (isLike) {
				// Change the dislike link to 'dislike'
				event.target.nextElementSibling.innerText = 'Dislike';
			} else { // I clicked the dislike link
				// Change the like link to 'like'
				event.target.previousElementSibling.innerText = 'Like';
			}
	});

});