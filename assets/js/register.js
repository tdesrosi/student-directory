$(document).ready(function(){

    //On click signup, hide/show login/register form
    $("#signup").click(function(){
        $("#first").slideUp("slow", function(){
            $("#second").slideDown("slow");
        });
    });

    //On click signup, hide/show login/register form
    $("#signin").click(function(){
        $("#second").slideUp("slow", function(){
            $("#first").slideDown("slow");
        });
    });



})