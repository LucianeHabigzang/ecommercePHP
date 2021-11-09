$(document).ready(function(){
	
	//OBTEM ITENS
	function getItens(){
		$.post('../ajax/carrinho.php', {acao: 'getCarrinho'}, getCart, "json");
	}

	//FUNÇÂO GETCART
	function getCart(data){

		var carrinho = $("#cartAll");
		var countCart = carrinho.find("#countCart");
		var tbody = carrinho.find("tbody");
		var totalCart = carrinho.find("#totalCart");

		var tr = '';

		if(data.count > 0){

			$.each(data.dados, function(i, val){

				tr += '<tr>';
					tr += '<td>'+data.dados[i].nome+'</td>';
					tr += '<td style="text-align:center;">'+data.dados[i].qtd+'</td>';
					tr += '<td>'+data.dados[i].subtotal+'</td>';
					tr += '<td><a style="font-family:none; font-size:100%;" href="#" id="removeIten" data-id="'+data.dados[i].id+'"><span>Retirar</span></a></td>';
				tr += '</tr>';
			});

		}else{
			tr += '<tr><td colspan="3">Nenhum produto Adicionado</td></tr>';
		}

		//INSERIR INFORMAÇÔES
		countCart.text("Carrinho ("+data.count+")");
		totalCart.text("R$ "+data.totalCarrinho);
		tbody.empty().append(tr);
	}

	 $("#adicionar").click(function(){
	 	var codigoProduto = $('input[name="codigoProduto"]').val();
	 	var quantidade = $('input[name="quantidade"]').val();
	 	var tamanho = $('input:radio[name="tamanho"]:checked').val();
	 	var inputQtd = $('input[name="quantidade"]');
	 	var status = $('#status');
		
	 	$.ajax({
	 		url: '../ajax/carrinho.php',
	 		type: 'POST',
	 		data: 'produto='+codigoProduto+'&quantidade='+quantidade+'&tamanho='+tamanho+'&acao=add',
	 		dataType: 'json',
	 		beforeSend: function(){
	 			$("#adicionar").attr('disabled', 'disabled');
				$("#carregando").fadeIn('slow');
				status.hide('slow');
	 		},

	 		success: function(data){
				
	 			if(data == 'notQtd'){
	 				inputQtd.val(1);
	 				status.html('<div>N&atilde;o temos em estoque a quantidade solicitada! <br />  <a href="../registrar_interesse/'+ codigoProduto +'/'+ quantidade +'">Registrar interesse no produto</a></div>').show('slow');
	 			}else if(data == 'notProd'){
					status.html('<div>O produto n&atilde;o esta mais disponivel!</div>').show('slow');
	 			}else{
					
	 				getCart(data);
	 			
	 			}

	 			$("#carregando").fadeOut('slow', function(){
	 				$("#adicionar").attr('disabled', false);
	 			});
	 		}

	 	});
	 });

	//RETIRA PRODUTO DO CARRINHO
	$("#cartAll").on('click', '#removeIten', function(e){
		var key = $(this).attr('data-id');

		//REQUISIÇÂO
		$.post('../ajax/carrinho.php', {acao: 'deleteIten', id: key}, function(retorno){

			if(retorno == 'OK'){
				getItens();
			}

		}, "json");

		return false;
	});
	
	$("#ItemCarrinho").on('click', '#carrinhoRemoveItem', function(e){
		var key = $(this).attr('data-id');
		
		//REQUISIÇÂO
		$.post('../ajax/carrinho.php', {acao: 'deleteIten', id: key}, function(retorno){
			
			if(retorno == 'OK'){
				location.reload();
			}
		
		}, "json");
		
	return false;
	});

	//MOSTRA PRODUTOS NO CARRINHO
	getItens();

});

function ChangeTipoFrete(radio, valor)
{   
	document.getElementById("ValorTotal").innerHTML = "Valor Total:  R$ " + valor;
}  
