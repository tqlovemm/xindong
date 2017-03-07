
function notes(id,con){

    var cons = $(con);
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function stateChanged()
    {
        if (xhr.readyState==4 || xhr.readyState=="complete")
        {
            cons.html(xhr.responseText);

        }
    };
    xhr.open('get','/index.php/forum/thread/note?id='+id);
    xhr.send(null);
}

function clear_list(content){
    var con = $(content);

    if(con.siblings('.show_reply').css('display')=='none'){

        con.siblings('.show_reply').show();
        con.siblings('.show_post').show();

    }else{

        con.siblings('.show_reply').hide();
        con.siblings('.show_post').hide();
    }

}

function read(){
    var xhr = new XMLHttpRequest();
    xhr.open('get','/index.php/forum/thread/read');
    xhr.send(null);
}
function reply(id,content){
    var content1 = $(content);
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function stateChanged()
    {
        if (xhr.readyState==4 || xhr.readyState=="complete")
        {
            content1.siblings('.show_reply').html(xhr.responseText);
        }
    };
    xhr.open('get','/index.php/forum/thread/reply?id='+id);
    xhr.send(null);
}
function post(id,content){

    var content2 = $(content);

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function stateChanged()
    {
        if (xhr.readyState==4 || xhr.readyState=="complete")
        {
            content2.siblings('.show_post').html(xhr.responseText);
        }
    };
    xhr.open('get','/index.php/forum/thread/showpost?id='+id);
    xhr.send(null);
}

/*弹出框*/

function show_info(content){


    var con = $(content);

    setTimeout(function(){
        con.children('.show_info').show();
    },300);
    stop(true,true);

}


function hidden_info(content){


    var con = $(content);
    setTimeout(function(){
        con.children('.show_info').hide();
    },300);
    stop(true,true);


}


function claims($id,content){

    var con = $(content);
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function stateChanged()
    {
        if (xhr.readyState==4 || xhr.readyState=="complete")
        {
            con.siblings('.show-claims').html(xhr.responseText);
        }
    };
    xhr.open('get','/index.php/user/user-claims/index?id='+$id);
    xhr.send(null);


}
function stick(id){

    var xhr = new XMLHttpRequest();
    xhr.open('get','/index.php/forum/thread/stick?id='+id);
    xhr.send(null);
    history.go(0);

}






