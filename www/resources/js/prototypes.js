String.prototype.toProperCase = function () {
    return this.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
};

String.prototype.replaceChar = function(search, replace) {
    return this.split(search).join(replace);
};

String.prototype.isEmail = function () {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this);
};