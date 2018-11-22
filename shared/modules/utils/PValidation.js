
function isNull(toCheck){
    if(Array.isArray(toCheck)){
        for(var e = 0; e < toCheck.length; e++){
            if(toCheck[e] == null) return true;
        }
        return false;
    }else{
        if(toCheck == null) return true;
        return false;
    }
    return false;
}

function isEmpty(toCheck){
    if(Array.isArray(toCheck)){
        for(var e = 0; e < toCheck.length; e++){
            if(toCheck[e] == null || toCheck[e] == "") return true;
        }
        return false;
    }else{
        if(toCheck == null || toCheck == "") return true;
        return false;
    }
    return false;
}

function getEmptyIndex(toCheck){
    if(Array.isArray(toCheck)){
        for(var e = 0; e < toCheck.length; e++){
            if(toCheck[e] == null || toCheck[e] == "") return e;
        }
        return -1;
    }else{
        if(toCheck == null || toCheck == "") return 0;
        return -1;
    }
    return -1;
}