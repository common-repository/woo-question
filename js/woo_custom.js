jQuery( document ).ready(function() {
	
	
	
      jQuery("#ppl").change(function(){
		  
		jQuery(".question_submit").css("display","block");
		  

    // The easiest way is of course to delete all textboxes before adding new ones
    //jQuery("#question_holder").html("");
    
    var count = jQuery("#question_holder input").size();
    var requested = parseInt(jQuery("#ppl").val(),10);
    
    if (requested > count) {
		
		
        for(i=count; i<requested; i++) {
			
			var j = i+1;
			
			
       // var $ctrl = jQuery('<label>Question '+j+'</label><input/>').attr({ type: 'text', name:'text['+i+']', value:''});
	   		
		var $ctrl	= '<div class="question_section"><label>Question '+j+'</label><input type="text" value="" name="question['+i+']" /></div>';
			
		  //jQuery("#question_holder").append('<label>Question '+j+'</label><input type="text" value="" name="text['+i+']" />');
           jQuery("#question_holder").append($ctrl);
		   
		   
        }
    }
    else if (requested < count) {
        var x = requested - 1;
        jQuery("#question_holder input:gt(" + x + ")").remove();
		jQuery("#question_holder label:gt(" + x + ")").remove();
    }
});



});
