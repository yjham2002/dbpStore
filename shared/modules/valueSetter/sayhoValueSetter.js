
function bindData(row, type){
    if(type == "input")
        setInputValue(row, Object.keys(row));
    if(type == "html")
        setHtmlValue(row, Object.keys(row));
}

function setInputValue(row, aliases){
    for(var e = 0; e < aliases.length; e++) {
        var alias = aliases[e];
        //radio일 경우
        if($("[name=" + alias + "]").attr("type") == "radio")
            $("[name=" + alias + "][value=" + row[alias] + "]").prop("checked", true);
        else
            $("[name=" + alias + "]").val(row[alias]);
    }
}

function setHtmlValue(row, aliases){
    for(var e = 0; e < aliases.length; e++){
        var alias = aliases[e];
        $("[name=" + alias + "]").html(row[alias]);
    }
}