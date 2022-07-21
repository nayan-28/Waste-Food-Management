	/*Author Jomaddar IT
	 url: https://jomaddarit.com
	*/
	/**When keyup qty Field this function Run*/
	function qty(id)
	{
		var qty = $('#qty_'+id).val();
		var price = $('#price_'+id).val();
		var total = $('#totalamounval').val();
		var result = Number(qty)*Number(price);
		$('#subtotal_'+id).val(result);
		total_price();
	}
	/**When keyup price Field this function Run*/
	function price(id)
	{
		var qty = $('#qty_'+id).val();
		var price = $('#price_'+id).val();
		var total = $('#totalamounval').val();
		var result = Number(qty)*Number(price);
		$('#subtotal_'+id).val(result);
		var totalamount = Number(result)+Number(total);
		$('#totalamounval').val(totalamount);
		total_price();
	}
	/**call every keyup from any function*/
	function total_price()
	{
		var total = 0;
		$('input.subtotal').each(function() {
				total +=Number($(this).val()); 
		});
		$('#totalamounval').val(total);
	}
	/*Add Row Item*/
	$(document).ready(function(){
		var i = 1;
		$('.addrow').click(function()
			{i++;
				html ='';
				html +='<div id="remove_'+i+'" class="post_item col-md-12">';
	            html +='	<div class="col-md-3"><input type="text" placeholder="Title" required="" name="item_name[]" class="form-control"></div>';
	            html +='		<div class="col-md-2"><input type="number" placeholder="qty" id="qty_'+i+'" required="" onkeyup="return qty('+i+')" name="qty[]" class="form-control"></div>';
	            html +='		<div class="col-md-2"><input type="number" id="price_'+i+'" placeholder="Price" required="" onkeyup="return price('+i+')"  name="price[]" class="form-control"></div>';
	            html +='		<div class="col-md-3"><input type="number" placeholder="subtotal" id="subtotal_'+i+'" readonly   name="subtotal[]" class="form-control subtotal"></div>';
	            html +='		<div class="col-md-2"><span class="btn btn-danger" onclick="return remove('+i+')"><i class="fa fa-times" aria-hidden="true"></i></span></div>';
	            html +='	</div>';
	            $('#showItem').append(html);
			});
	});
	function remove(id)
	{
		$('#remove_'+id).remove();
		total_price();
	}