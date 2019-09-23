$(document).ready(function() {
	$('#new-friend').keyup(function(event) {
		let search = $(this).val();
		$('.new-friend-list').html("<img src='images/loading.gif'>");
		$.post('findNewFriend.php', {username: search}, function(data, textStatus, xhr) {
			$('.new-friend-list').html('<ul>' + data + "</ul>");
			// console.log(data);
		});
	});

	$(document).on('click', '.fa-thumbs-up', function(event) {
		let id = $('.fa-thumbs-up').index($(this));
		let t = $('.fa-thumbs-up')[id];
		if(!$(t).hasClass('liked')) {
			$(t).addClass('liked');
			$(t).addClass('animate-for-like');
			let l = $('.dem-like')[id];
			let like = $(l).html();
			like++;
			$(l).html(like);
			let ava = $('.main').attr("userava");
			let username = $('.main').attr("username");
			let from = $('.main').attr('usingid');
			let p = $('.post')[id];
			let to = $(p).attr('id');
			c.likeNotice(from, ava, username, to);
			$.post('addLike.php', {from, ava, username, to}, function(data, textStatus, xhr) {
			});
		}
	});

	$('.fa-comment').click(function(event) {
		let id = $('.fa-comment').index($(this));
		let t = $('.comment-container')[id];
		t = $(t);
		t.slideDown();
	});
	
	$('.bg-for-notice').click(function(event) {
		$(this).hide();
		$('.dropdown-notice').hide();
	});

	$('#notification').click(function(event) {
		$('.dropdown-notice').show();
		$('.bg-for-notice').show();
	});

	$('.submit-yourcomment').click(function(event) {
		event.preventDefault();
		let id = $('.submit-yourcomment').index($(this));
		let t = $('.ip-your-comment')[id];
		let ava = $('.main').attr('userava');
		let username = $('.main').attr('username');
		let keep = $(t);
		t = $(t).val();
		let userId = $('.main').attr('userid');
		let to = $('.post')[id];
		to = $(to);
		to = to.attr('id');
		let cm = $('.comment-container')[id];
		cm = $(cm);
		if(t != '') {
			c.commentNotice(userId, ava, username, to, t);
			$.post('addComment.php', {comment: t, from: userId, to, ava, username}, function(data, textStatus, xhr) {
					addComment(id, ava, username, t, userId);
			});
		}
		keep.val('');
	});
});

function addComment(id, ava, username, comment, userId) {
	let t = $('.comment-container')[id];
	$(t).append(`
		<div class="comment">
			<div class="comment-info">
				<div class="ava-author-comment">
					<img src="avatar/` + ava + `">
				</div>
				<a href="profile.php?id=` + userId + `">` + username + `</a>
			</div>
			<div class="comment-content">
				<p>` + comment + `</p>
			</div>
		</div>
	`);
}