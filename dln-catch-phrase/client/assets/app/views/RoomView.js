app.views.RoomView = Backbone.View.extend({

	initialize: function () {
		var that = this;
		app.utils.templates.get( 'RoomView', function ( tpl ) {
			that.render( tpl );
		} );

		var room_item = new app.views.RoomItemView();
		room_item.render();
	},

	getCurrentUserID: function () {
		var user_id   = parseInt( $('#dln_user_id').val() );
		if ( ! user_id ) {
			alert( 'User không tồn tại!' );
		}
		return user_id;
	},

	render: function ( tpl ) {
		var that = this;
		$('#main .content').html( tpl );
		var user_id = that.getCurrentUserID();
		var socket  = DLN_Socket.getInstance().socket;

		// Create room
		$('#dln_create_room').on( 'click', function (e) {
			e.preventDefault();

			var room_name = $('#dln_room_name').val();
			var money     = $('#dln_room_money').val();
			var code      = DLN_Encrypt.get_encrypt();
			if ( socket && user_id && room_name ) {
				socket.emit( 'create-room', { user_id: user_id, room_name: room_name, money: money, code: code } );
			} else {
				alert( 'Không thể tạo phòng!' );
			}
		} );

		// Join room
		$('.dln_join_room').each(function () {
			$(this).on( 'click', function (e) {
				e.preventDefault();

				// Get current room ID
				var room_id = parseInt( $(this).find('.room_id').val() );
				if ( ! room_id ) {
					alert( 'Phòng không tồn tại!' );
				}

				socket.emit( 'join-room', { user_id: user_id, room_id: room_id } );
			} );
		});
	}
});