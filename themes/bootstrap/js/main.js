/* javascript ruben temporal 
if ( document.getElementById( "youtube-field-player" )) {
	
}else{
	document.getElementById("field--name-field-descripcion").classList.add("desaparecer");
	var MyDiv1 = document.getElementById('field--name-field-descripcion');
	var MyDiv2 = document.getElementById('MyDiv2');
	MyDiv2.innerHTML = MyDiv1.innerHTML;
}
fin javascript ruben temporal */

var elemento = document.querySelectorAll(".expanded");
for (var i = 0; i < elemento.length; i++) {
  elemento[i].classList.add("open");
}


var elemento = document.querySelectorAll(".dropdown-toggle");
for (var i = 0; i < elemento.length; i++) {
  elemento[i].setAttribute("data-toggle", "Valor para ese atributo");
}

var elemento = document.querySelectorAll("#menu-principal .navbar-nav");
for (var i = 0; i < elemento.length; i++) {
  elemento[i].classList.add("menu-part");
}


(function ($, Drupal) {
  Drupal.behaviors.myModuleBehavior = {
    attach: function (context, settings) {



				$( ".views-exposed-form .option" ).click(function() {
				  $( ".views-exposed-form" ).submit();
				});

				$( "#field--name-field-resumen a" ).click(

					function() {
									$(".page-node-type-corazon-colombia article .field--name-body").slideToggle( 1000 );
					}


				);


				$( ".view-busca-tu-especialista form .form-type-select label" ).click(

					function() {
									$(".view-busca-tu-especialista form .form-type-select .select-wrapper").css("display", "block");

									$(".view-busca-tu-especialista form input[type='text']").css("display", "none");

									$(".view-busca-tu-especialista form .form-type-textfield label").css("background", "#e5e5e5");

									$(".view-busca-tu-especialista form .form-type-select label").css("background", "#f7f7f7");



									
					}


				);
				

				$(".view-busca-tu-especialista form input[type='text']").attr("placeholder", "Buscar por nombre o apellido");

				$( ".view-busca-tu-especialista form .form-type-textfield label" ).click(

					function() {
									$(".view-busca-tu-especialista form .form-type-select .select-wrapper").css("display", "none");

									$(".view-busca-tu-especialista form input[type='text']").css("display", "block");

									$(".view-busca-tu-especialista form .form-type-select label").css("background", "#e5e5e5");

									$(".view-busca-tu-especialista form .form-type-textfield label").css("background", "#f7f7f7");


									
					}


				);

				$( ".page-node-type-pacientes-y-familia form .form-type-select label" ).click(

					function() {
									$(".page-node-type-pacientes-y-familia form .form-type-select .select-wrapper").css("display", "block");

									$(".page-node-type-pacientes-y-familia form input[type='text']").css("display", "none");

									$(".page-node-type-pacientes-y-familia form .form-type-textfield label").css("background", "#e5e5e5");

									$(".page-node-type-pacientes-y-familia form .form-type-select label").css("background", "#f7f7f7");



									
					}


				);
				

				$(".page-node-type-pacientes-y-familia form input[type='text']").attr("placeholder", "Escriba el nombre del especialista");

				$( ".page-node-type-pacientes-y-familia .form-type-textfield label" ).click(

					function() {
									$(".page-node-type-pacientes-y-familia form .form-type-select .select-wrapper").css("display", "none");

									$(".page-node-type-pacientes-y-familia form input[type='text']").css("display", "block");

									$(".page-node-type-pacientes-y-familia form .form-type-select label").css("background", "#e5e5e5");

									$(".page-node-type-pacientes-y-familia form .form-type-textfield label").css("background", "#f7f7f7");


									
					}


				);


				 $('#icono-buscar').hover(function() {
				    $('#form-buscar').css('display', 'block');
				  });


				 

				 $("#form-buscar .form-search").attr("placeholder", "Escriba las palabras clave.");

				 
				 $('.menusectionscontainer-home ul li a').click(function(e){
				  	  e.preventDefault();
				      
				      enlace  = $(this).attr('href');

				      $('html, body').animate({

				          scrollTop: $(enlace).offset().top -250

				      }, 

				      1000);
				  });




				

				 $(function(){
				   $(".accordion").click(function(e){
				            
				         e.preventDefault();
				     
				         var contenido=$(this).next(".dropdown-menu");

				         if(contenido.css("display")=="none"){ //open		
				           contenido.slideDown(250);			
				           $(this).addClass("open");
				         }
				         else{ //close		
				           contenido.slideUp(250);
				           $(this).removeClass("open");	
				         }

				       });
				 });

				 $("#videoservicios .select-wrapper").after(" ");



			
	             var label1 = $('.form-radio:checked').parent();

	             label1.css('color','#941c35');

	             label1.addClass('label-item');


	             var menuactivo =$('.active');


	             	

	            $( ".page-node-type-paciente-internacional .view-paciente-internacional button" ).click(

	            	function() {
	            					$(".quicktabs-tabs").slideToggle( 1000 );
	            	}


	            );

	            $( ".loaded" ).click(function() {
	            					$(".page-node-type-paciente-internacional .quicktabs-tabs").hide();
	            	});

	            $( ".volver-pacientes" ).click(function() {
	            					$(".page-node-type-paciente-internacional .quicktabs-tabs").show();
	            	});

	            /*var url = location.hash;

	            $('html, body').animate({

	                     scrollTop: $(url).offset().top -250

	                 }, 

	                 1000);*/
	           

	            


	            

			}
	  };
	})(jQuery, Drupal);
