
// B2E
$(document).ready(function(){
    $('.modal-trigger').leanModal();
    
    $("header .button-collapse").sideNav();
    
    $("#mobile-demo li a, #nav-web li a").click(function (e){
        if($(this).attr("href")!="?lang=es" && $(this).attr("href")!="?lang=en"){
            if($(this).attr("href")){
                var link = $(this).attr("href").replace("#", "");
                var destiny = $("a[name='" + link + "']"), y = 0, offset;
                if (link != "" && destiny.length){
                    offset = destiny.offset();
                    if (offset != null){
                        y = offset.top;
                        scroll(y);
                    }
                }       
                return false;
            } else {
                e.stopImmediatePropagation();
            }
        }
    });
    
    $("#mobile-demo li a").click(function (){
        $("header .button-collapse").sideNav("hide");
        $('#sidenav-overlay').remove();
    });

    
    $('.button-collapse').sideNav('hide');
    //contact form
    var contact = $("form[name='contact']");
    contact.submit(function(){
        var btn_submit = $(this).find("button[type='submit']");
        btn_submit.attr("disabled", "disabled").find("i.fa")
                .removeClass("fa-send").addClass("fa-spinner fa-spin");
        $.ajax({
            url: $(this).attr("action"),
            data: $.param($(this).find("input, textarea")),
            type: "post",
            dataType: "json",
            success: function (data){
                if (data == 0){
                    btn_submit.find("i.fa").addClass("fa-times");
                } else {
                    btn_submit.find("i.fa").addClass("fa-check");
                }
            },
            error: function (){
                btn_submit.find("i.fa").addClass("fa-times");
            },
            complete: function (){
                btn_submit.attr("disabled", null).find("i.fa")
                        .removeClass("fa-spinner fa-spin");
            }
        });
        
        return false;
    });
    
    $(".portada").height($(window).height());
});

$(document).ready(function(){
	$('.parallax').parallax();
});
        


function scroll (y) {
    $("html,body").animate({scrollTop: y}, 1000);
}

 

   $(document).ready(function(){
    $('.collapsible').collapsible({
      accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
    });
  });

      


 //    function initMap() {

 //        var posicion = { lat: 19.425236, lng: -99.203990 };
 //        var mapDiv = document.getElementById('map');
 //        // Creando el mapa
 //        var map = new google.maps.Map(mapDiv, {
 //            center: posicion,
 //            scrollwheel: false,
 //            zoom: 17
 //        });
 //        var marker = new google.maps.Marker({
 //            position: posicion,
 //            map: map
 //            //icon: '/img/80YjG.png'
 //        });
 //    }


 //    AIzaSyDhWqvu1Jbkhr375KqrrVtU1bF7DruuE-0

 //    AIzaSyCIezYzfDf-0LnSjbf5gEZzU7DSfr9i0yk

      