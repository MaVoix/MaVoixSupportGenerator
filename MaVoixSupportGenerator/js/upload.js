// JavaScript Document
$(document).on('click', '#close-preview', function(){ 
    $('.image-preview').popover('hide');
    // Hover befor close the preview
    $('.image-preview').hover(
        function () {
           $('.image-preview').popover('show');
        }, 
         function () {
           $('.image-preview').popover('hide');
        }
    );    
});

$(function() {
    // Create the close button
    var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class","close pull-right");
    // Set the popover default content
    $('.image-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>Prévisualisation</strong>"+$(closebtn)[0].outerHTML,
        content: "Pas d'image ...",
        placement:'bottom'
    });
    // Clear event
    $('.image-preview-clear').click(function(){
        $('.image-preview').attr("data-content","").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("Parcourir"); 
    }); 
    // Create the preview image
    $(".image-preview-input input:file").change(function (){   
		
       	$('.waiting-submit').html('Patientez <span class="fa fa-spinner fa-spin"></span>');
		$('.waiting-submit').prop( "disabled", true );
 
		var img = $('<img/>', {
			id: 'dynamic',
			width:200          
		});   
		img.css({"max-height":300})
		var file = this.files[0];
		var reader = new FileReader();
		// Set preview image into the popover data-content
		reader.onload = function (e) {
			if(file.size>$("#maxfilesize").val()){
				toastr['error']("Votre fichier est trop lourd !", "Oops !");
			}else{	

				$(".image-preview-input-title").text("Autre");
				$(".image-preview-clear").show();
				$(".image-preview-filename").val(file.name);   
				img.attr('src', e.target.result);
				 if($(window).width()>600){
					$(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
				 }
			}
			$('.waiting-submit').html('Suite <span class="glyphicon glyphicon-circle-arrow-right"></span>');
			$('.waiting-submit').prop( "disabled", false );

		}        
		reader.readAsDataURL(file);
				
    });  
});