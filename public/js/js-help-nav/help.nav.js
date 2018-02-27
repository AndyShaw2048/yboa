$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
$(document).ready(function(){
    $("#firstpane .menu_body:eq(0)").show();
    $("#firstpane p.menu_head").click(function(){
        $(this).addClass("current").next("div.menu_body").slideToggle(300).siblings("div.menu_body").slideUp("slow");
        $(this).siblings().removeClass("current");
    });
    $("#secondpane .menu_body:eq(0)").show();
    $("#secondpane p.menu_head").mouseover(function(){
        $(this).addClass("current").next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
        $(this).siblings().removeClass("current");
    });

    var element = document.getElementById('content');
    $(".description").click(function(event){
        x = event.currentTarget;
        $.ajax({
            url: "http://oa.com/help/getcontent",
            type: "post",
            contentType: "application/json;charset=utf-8",
            data :JSON.stringify({'id': x.id}),
            dataType : "json",
            success : function(result) {
                //console.log('Success:'+result);
                element.innerHTML = result;
            },
            error : function(msg){
                console.log('Error:'+JSON.stringify(msg));
            }
        })
    });
});

