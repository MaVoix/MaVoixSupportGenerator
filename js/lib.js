// JavaScript Document

toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-center",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}

var $oObjCrop;

$( window ).resize(function() {
	//fix footer position
	$('.page').css('min-height',$(window).height()-300);
});

$(document).ready(function(){
	
	//fix footer position
	$('.page').css('min-height',$(window).height()-300);
	
	
	var $body=$('body');
	var $message=$('.erreur');


	
	$message.each(function(){
		toastr[$(this).data("type")]($(this).find("p").html(), $(this).find("h3").html())
	});
	
	$('form').on('submit',function(){
		$('.waiting-submit').html('Patientez <span class="fa fa-spinner fa-spin"></span>');
	});

    $(".jsSelectPreview").on('change',function(){
        var url=$(this).find(":selected").data("thumb");
        var $preview=$(".jsZonePreview");
       // $preview.html("");
        if(url){
            $preview.css('background-image','url('+url+'?v='+(Math.random()*1000) +')');
       /*     var img = $('<img/>', {
                id: 'dynamic',
                height:100,
                width:'auto',
                src: url+'?v='+(Math.random()*1000)
            });

            $preview.append(img);*/
        }

    });
	
	//maintien la session active et conserve les fichiers toutes les 2 min
	setInterval(function(){
		$.ajax({url : 'keep-alive.php'})
	},1000*60*2);
	
	//Crop image	
	var $img=$('#photocrop-src');
	var sUrl=$img.data('url');
	var nAngle=0;
	
	var el = document.getElementById('photocrop');
	if(el){
		
		var objPhotocrop = new Croppie(el, {
			viewport: { width:  $img.data('widthcrop'), height: $img.data('heightcrop') },
			boundary: { width: 200, height: 200 },
			showZoomer: true,
			enableOrientation: true
		});
		
		objPhotocrop.bind({
			url: sUrl,
			orientation: 1
		});		

		$('.photocrop-rotate').on('click', function(ev) {
			objPhotocrop.rotate(parseInt($(this).data('deg')));
			nAngle+=parseInt($(this).data('deg'));
			if(nAngle<0){
				nAngle+=360;
			}
		});	
		
		setInterval(function(){ 
			var resultCrop=objPhotocrop.get();
			$('#photocrop-x1').val(Math.round(resultCrop.points[0]*resultCrop.zoom));
			$('#photocrop-y1').val(Math.round(resultCrop.points[1]*resultCrop.zoom));
			$('#photocrop-x2').val(Math.round(resultCrop.points[2]*resultCrop.zoom));
			$('#photocrop-y2').val(Math.round(resultCrop.points[3]*resultCrop.zoom));
			$('#photocrop-zoom').val(resultCrop.zoom);
			$('#photocrop-angle').val(nAngle);			
		/*	$('#photocrop-x1').attr('type','text');
			$('#photocrop-y1').attr('type','text');
			$('#photocrop-x2').attr('type','text');
			$('#photocrop-y2').attr('type','text');
			$('#photocrop-zoom').attr('type','text');
			$('#photocrop-angle').attr('type','text');*/
		},500);
	}
	
	

	
	
});