<div id='principalRestrita'>
	<!-- Menu Area Restrita -->
	<?php include_once 'includes/areaRestritaMenu.php'; ?>
	<div id="restrita">
		<?php
		if (isset($_SESSION["TipoUsuario"]) && (($_SESSION["TipoUsuario"] == 2) || ($_SESSION["TipoUsuario"] == 3))) {
				
		?>	
		<div id="tituloProdutos">
			<div><h2>Gr&aacute;fico de vendas</h2></div>
		</div>
		
		<div id="area_grafico">
			

    <!-- Carregar a API do google -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

    <!-- Preparar a geracao do grafico -->
    <script type="text/javascript">

      /**
       * Funcao que preenche os dados do grafico
       */
     
      function desenharGrafico() {
        // Montar os dados usados pelo grafico
            
            var graficoData = '<?php echo graficoData(); ?>';
	 		obj = JSON.parse(graficoData);
	 		
	 		debugger;
	 		var dados = new google.visualization.DataTable(); 
	 		dados.addColumn('string', 'Produto');
	        dados.addColumn('number', 'Quantidade');
 
	 		dados.addRows(obj.length);
             for (var i = 0; i < dados['Nf'].length; i++)
             {
                dados['Nf'][i]['c'][0]['v'] = obj[i]['Titulo'];
                dados['Nf'][i]['c'][1]['v'] = obj[i]['qtd'];
            }
            
	        // Configuracoes do grafico
	        var config = {
	            'title':'Total de vendas',
	            'width':700,
	            'height':500
	        };
	
	        // Instanciar o objeto de geracao de graficos de pizza,
	        // informando o elemento HTML onde o grafico sera desenhado.
	        var chart = new google.visualization.ColumnChart(document.getElementById('area_grafico'));
	
	        // Desenhar o grafico (usando os dados e as configuracoes criadas)
	        chart.draw(dados, config);
        
      }
      
      // Carregar a API de visualizacao e os pacotes necessarios.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Especificar um callback para ser executado quando a API for carregada.
      google.setOnLoadCallback(desenharGrafico);

    </script>
			
		</div>
		
		<?php 
		} else {
			echo '<div id="divLinhaProd">Acesso Restrito! Efetue o login!</div>';
		}
		?>
	</div>
</div>