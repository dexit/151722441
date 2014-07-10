function Room( name, id, owner, time_create ){
	this.name        = name;
	this.id          = id;
	this.owner       = owner;
	this.people      = [];
	this.peopleLimit = 1000;
	this.status      = 'available';
	this.private     = false;
	this.time_create = time_create;
	this.match_id    = '';
};

Room.prototype.addPerson = function (personID) {
	if ( this.status === 'available' ) {
		this.people.push(personID);
	}
};

Room.prototype.removePerson = function (person) {
	var personIndex = -1;
	for( var i = 0; i < this.people.length; i ++ ) {
		if ( this.people[i].id === person.id ) {
			personIndex = i;
			break;
		}
	}
	this.people.remove(personIndex);
};

Room.prototype.getPerson = function (personID) {
	var person = null;
	for( var i = 0; i < this.people.length; i++ ) {
		if ( this.people[i].id == personID ) {
			person = this.people[i];
		}
	}
	return person;
};

Room.prototype.isAvailable = function() {
	if (this.available === "available") {
		return true;
	} else {
		return false;
	}
};

Room.prototype.isPrivate = function() {
	if (this.private) {
		return true;
	} else {
		return false;
	}
};

module.exports = Room;