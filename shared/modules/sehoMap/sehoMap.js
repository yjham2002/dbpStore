var sehoMap = function(){
    this.map = new Object();
    return this;
};

sehoMap.prototype = {
    put : function(key, value){
        this.map[key] = value;
        return this;
    },
    get : function(key){
        return this.map[key];
    },
    containsKey : function(key){
        return key in this.map;
    }
};
