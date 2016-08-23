var colCount = 0;
var colWidth = 350;
var margin = 10;
var spaceLeft = 0;
var windowWidth = 0;
var blocks = [];


$(function(){
	$(window).resize(setupBlocks);
	
	$(window).scroll(function(){      
     var $doc_height,$s_top,$now_height;  
     $doc_height = $(document).height();        
     $s_top = $(this).scrollTop();           
     $now_height = $(this).height();

	 //console.log($s_top);
     if(($doc_height - $s_top - $now_height) < 100) jsonajax();      
 	});
	
});

$(window).load(function(){ 
	jsonajax(); 
});


$(window).scroll(function(){      
     var $doc_height,$s_top,$now_height;  
     $doc_height = $(document).height();        
     $s_top = $(this).scrollTop();           
     $now_height = $(this).height();
     if(($doc_height - $s_top - $now_height) < 100) {
     	//console.log($doc_height - $s_top - $now_height);
     	jsonajax()
        console.log($num);
     }      
 });

var $num = 0;  
function jsonajax(){  
     
     $.ajax({  
         url:'../includes/ajax/getIdeas.php',  
         type:'POST',  
         data:"num="+$num++,  
         dataType:'json',  
         success:function(ideas){ 
         	//console.log(ideas);
             if(typeof ideas == 'object'){           
             	setupBlocks();
             	for(var i=0,l=ideas.length;i<l;i++){
                	var $block = $('<div>').addClass('block');
                	$('<img>').attr('src',ideas[i].picture).appendTo($block);
                	$('<p>'+ideas[i].goal+'<p/>').appendTo($block);
                	$('#results').append($block);
                }
                setupBlocks();
             }
         }  
     });  
 }  


function setupBlocks() {
	windowWidth = $('#results').width();
    //console.log(windowWidth);
	blocks = [];

	// Calculate the margin so the blocks are evenly spaced within the window
	colCount = Math.floor(windowWidth/(colWidth+margin*2));
	spaceLeft = Math.floor((windowWidth - ((colWidth*colCount)+(margin*(colCount-1)))) / 2);
	//console.log(spaceLeft);
	
	for(var i=0;i<colCount;i++){
		blocks.push(margin+200);
	}
	positionBlocks();
}

function positionBlocks() {
	$('.block').each(function(i){
		var min = Array.min(blocks);
		var index = $.inArray(min, blocks);
		var leftPos = margin+(index*(colWidth+margin));
		$(this).css({
			'left':(leftPos+spaceLeft)+'px',
			'top':min+'px'
		});
		blocks[index] = min+$(this).outerHeight()+margin;
    	//console.log($(this).outerHeight());
	});	
}

// Function to get the Min value in Array
Array.min = function(array) {
    return Math.min.apply(Math, array);
};


