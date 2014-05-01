var $j = jQuery.noConflict(true);
$j(document).ready(function() {
     
    var owl = $j("#owl-demo");
     
    owl.owlCarousel({
	    items : 4, 
	});
     
    // Custom Navigation Events
    $j(".next").click(function(){
    	owl.trigger('owl.next');
    })
    $j(".prev").click(function(){
    	owl.trigger('owl.prev');
    })
    $j(".play").click(function(){
    	owl.trigger('owl.play',1000); //owl.play event accept autoPlay speed as second parameter
    })
    $j(".stop").click(function(){
    	owl.trigger('owl.stop');
    })
});

