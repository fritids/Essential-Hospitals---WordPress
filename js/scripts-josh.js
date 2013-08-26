//READY
$(document).ready(function() {

  /*********************SMOOTH SCROLL************************/
  
  
      //SMOOTH SCROLL
      $("#people").smoothDivScroll({
      	startAtElementId: "starter", 
       hotSpotScrollingInterval: 33
      });

      $('.people_box').mouseenter(function() 
        {
          $(this).find(".p_hover").show();
          }).mouseleave(function() {
            $(this).find(".p_hover").hide();
        });  

 

//END DOC 
});