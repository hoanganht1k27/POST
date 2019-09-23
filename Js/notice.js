var chatkit = function() {
	this.tokenProvider = new Chatkit.TokenProvider({
	  url: 'https://us1.pusherplatform.io/services/chatkit_token_provider/v1/0f1bd1bc-77a1-4414-bf4b-8c8dd8070de0/token'
	});

	this.chatManager = null;

	this.currentUser = null;
	this.userId = null;
	this.room = null;
	this.roomName = null;

	var self = this;

	this.init = function () {
		this.userId = $('.main').attr('usingid');
		this.roomName = this.userId;

		this.chatManager = new Chatkit.ChatManager({
		  instanceLocator: 'v1:us1:0f1bd1bc-77a1-4414-bf4b-8c8dd8070de0',
		  userId: this.userId,
		  tokenProvider: this.tokenProvider
		})

		this.chatManager.connect()
		.then(cU => {
			console.log('Successful connection', cU);
			self.currentUser = cU;
			$.post('getRoomId.php', {userId: self.userId}, function(data, textStatus, xhr) {
				self.room = data;
				self.subscribeToOwnRoom();
			});
		})
		.catch(err => {
			console.log('Error on connection', err);
		})
	}

	this.roomOfUser = function(userId, type, content) {
		let res = null;
		$.post('getRoomId.php', {userId}, function(data, textStatus, xhr) {
			res = data;
			if(type) {
				self.joinRoom(data, type, content, userId);
			}
		});

		return res;
	}

	this.subscribeToOwnRoom = function() {
		this.currentUser.subscribeToRoomMultipart({
		  roomId: this.room,
		  hooks: {
		    onMessage: message => {
		      // console.log("received message", message);
		      let ob = message.parts;
		      ob = ob[0].payload.content;
		      ob = JSON.parse(ob);
		      let type = ob.type;
		      let content = ob.content;
		      if(type == "like") {
		      	content = JSON.parse(content);
		      	let link = this.userId + '-' + content.toPost;
		      	let ava = content.ava;
		      	let username = content.username;
		      	console.log(username + " like your post", link);
		      	let html = `
		      		<li>
						<a href="profile.php#` + link + `">
							<div class="notice-ava">
								<img src="avatar/` + ava + `">
							</div>
							<p class="notice-content">` + username + ` liked your post</p>
						</a>
					</li>
		      	`;
		      	$('.dropdown-notice ul').prepend(html);
		      }
		      if(type == "comment") {
		      	content = JSON.parse(content);
		      	let link = this.userId + '-' + content.toPost;
		      	let ava = content.ava;
		      	let username = content.username;
		      	console.log(username + " comment your post", link);
		      	let html = `
		      		<li>
						<a href="profile.php#` + link + `">
							<div class="notice-ava">
								<img src="avatar/` + ava + `">
							</div>
							<p class="notice-content">` + username + ` commented in your post</p>
						</a>
					</li>
		      	`;
		      	$('.dropdown-notice ul').prepend(html);
		      }
		      if(type == "follow") {
		      	content = JSON.parse(content);
		      	let username = content.username;
		      	let from = content.from;
		      	console.log(username + " start following you");
		      	let html = `
		      		<li>
						<a href="profile.php?id=` + from + `">
							<div class="notice-ava">
								<img src="avatar/` + ava + `">
							</div>
							<p class="notice-content">` + username + ` starts following you</p>
						</a>
					</li>
		      	`;
		      	$('.dropdown-notice ul').prepend(html);
		      }
		    }
		  },
		  messageLimit: 0
		})
	}

	this.addFollowers = function(from, ava, username, to) {
		let ob = new Object();
		ob.from = from;
		ob.ava = ava;
		ob.username = username;
		ob = JSON.stringify(ob);
		let room = this.roomOfUser(to, "follow", ob);
	}

	this.joinRoom = function(room, type, content, userId) {
		this.currentUser.joinRoom({ roomId: room})
		  .then(room => {
		    let user = room.userStore.presenceStore;
		    let presence = new Array();
		    Object.keys(user).forEach(key => {
		    	presence[key] = user[key];
		    })
		    if(type) {
		    	let ob = new Object();
		    	if(type == "like") {
		    		ob.type = "like";
		    		ob.content = content;
		    		ob = JSON.stringify(ob);
		    		self.sendMessage(room.id, ob);
		    	}
		    	if(type == "comment") {
		    		ob.type = "comment";
		    		ob.content = content;
		    		ob = JSON.stringify(ob);
		    		self.sendMessage(room.id, ob);
		    	}
		    	if(type == "follow") {
		    		ob.type = "follow";
		    		ob.content = content;
		    		ob = JSON.stringify(ob);
		    		self.sendMessage(room.id, ob);
		    	}
		    	if(presence[userId] == "offline") {
		    		$.post('addNotification.php', {userId: this.userId}, function(data, textStatus, xhr) {
		    			
		    		});
		    	}
		    }
		  })
		  .catch(err => {
		    console.log(`Error joining room: ${err}`)
		  })
	}

	this.sendMessage = function(room, msg) {
		this.currentUser.sendSimpleMessage({
		  roomId: room,
		  text: msg,
		})
		.then(messageId => {
		  console.log(`Added message`)
		})
		.catch(err => {
		  console.log(`Error adding message: ${err}`)
		})
	}

	this.likeNotice = function(from, ava, username, to) {
		let keep = to.split('-');
		let toId = keep[0];
		let toPost = keep[1];
		let ob = new Object();
		ob.from = from;
		ob.ava = ava;
		ob.username = username;
		ob.toPost = toPost;
		ob = JSON.stringify(ob);
		let roomOfToId = this.roomOfUser(toId, "like", ob);
	}

	this.commentNotice = function(from, ava, username, to, comment) {
		let keep = to.split('-');
		let toId = keep[0];
		let toPost = keep[1];
		let ob = new Object();
		ob.from = from;
		ob.ava = ava;
		ob.username = username;
		ob.comment = comment;
		ob.toPost = toPost;
		ob = JSON.stringify(ob);
		let roomOfToId = this.roomOfUser(toId, "comment", ob);
	}
}