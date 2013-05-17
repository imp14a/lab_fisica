$("#addarticulo").click(function() {
				$.ajax({
					url : "paginas/CrearArticuloForm.html",
					context : document.body
				}).done(function(res) {
					$("#contenido").html(res);
				});
			});
			$(".inicio").click(function() {
				$.ajax({
					url : "paginas/control/main.php?controller=BlogControler&action=indexControl",
					context : document.body
				}).done(function(res) {
					$("#contenido").html(res);
				});
			});
			$("#ordenarTitulo").click(function() {
				$.ajax({
					url : "paginas/control/main.php?controller=BlogControler&action=ordenarTitulo",
					context : document.body
				}).done(function(res) {
					$("#contenido").html(res);
				});
			});
			$("#contenido").ready(function() {
				$.ajax({
					url : "paginas/control/main.php?controller=BlogControler&action=indexControl",
					context : document.body
				}).done(function(res) {
					$("#contenido").html(res);
				});
			});
			function mostrar(i) {
				$.ajax({
					url : "paginas/control/main.php?controller=BlogControler&action=mostrarArticulo&articulo=" + i,
					context : document.body
				}).done(function(res) {
					$("#contenido").html(res);
				});
			}

			function comentar(i) {

				var tit = $("#titulo").val();
				var text = $("#texto").val();
				var autor = $("#autor").val();

				var valida = validar();

				if(!valida) {
					return;
				}

				var urltogo = "paginas/control/main.php?controller=BlogControler" + "&action=agregarComentario&articulo=" + i + "&titulo=" + tit + "&texto=" + text + "&autor=" + autor;

				console.log(tit);
				$.ajax({
					url : urltogo,
					context : document.body
				}).done(function(res) {
					$("#contenido").html(res);
				});
			}

			function agregarArticulo() {
				var tit = $("#titulo").val();
				var text = $("#texto").val();
				var autor = $("#autor").val();

				var valida = validar();

				if(!valida) {
					return;
				}

				var url = "paginas/control/main.php?" + "controller=BlogControler&action=crearArticulo&titulo=" + tit + "&texto=" + text + "&autor=" + autor;
				$.ajax({
					url : url,
					context : document.body
				}).done(function(res) {
					$("#contenido").html(res);
				});
			}

			function validar() {
				valid = true;
				var tit = $("#titulo").val();
				var text = $("#texto").val();
				var autor = $("#autor").val();

				$("#errorTitulo").html("");
				$("#errorAutor").html("");
				$("#errorTexto").html("");
				if(tit.length == 0) {
					$("#errorTitulo").html("Debes ingresar el título");
					valid = false;
				}
				if(autor.length == 0) {
					$("#errorAutor").html("Debes ingresar el autor");
					valid = false;
				}
				if(text.length == 0) {
					$("#errorTexto").html("Debes agregar contenido");
					valid = false;
				}

				return valid;

			}