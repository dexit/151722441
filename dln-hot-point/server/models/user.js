var mongoose = require('mongoose'),
	Schema = mongoose.Schema;

var UserSchema = new Schema({
	name: String,
	email: String,
	username: String,
	user_image: String,
	provider_id: String,
	facebook: {},
	createAt: { type: Date, 'default': Date.now }
});

module.exports = mongoose.model('User', UserSchema);