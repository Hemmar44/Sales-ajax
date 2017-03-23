$(function(){
	//sum on other than name and product;
		var yesornoValue = $(".yesorno:checked").val();
		var globalValue = ""
		var sum = 0;
		var tableButtons = '</button><button type="button" id="delete" class="btn btn-warning btn-sm">Delete</button>'
		var inputValue = "";
		var min = 0;
		var max = 0;
		var get = 1;

		console.log("yesornovalue = " + yesornoValue + ", globalValue = " + globalValue + ", min = " + min);
    	console.log("min = " + min + ", inputValue = " + inputValue + ", get = " + get);
    	//on load call	
    	$.ajax({
  			method: "POST",
  			url: "ajax/Getdata.php",
  			context: this,
  			data: { column: globalValue, value: inputValue, completed: yesornoValue, min:min, max:max, get:1},
			success: function( msg ) {
    		var array = msg.split("||");
    		$("#dataTable tbody").html(array[0]).show();
    		$("#links").html(array[1]);
    		}
    	});
    	//on change links
		$("#links").on("click", "a", function() {
			get = $(this).attr("data");
			console.log("yesornovalue = " + yesornoValue + ", globalValue = " + globalValue + ", min = " + min);
    		console.log("min = " + min + ", inputValue = " + inputValue + ", get = " + get);
			$.ajax({
  			method: "POST",
  			url: "ajax/Getdata.php",
  			context: this,
  			data: { column: globalValue, value: inputValue, completed: yesornoValue, min:min, max:max, get:get},
			success: function( msg ) {
    		var array = msg.split("||");
    		$("#dataTable tbody").html(array[0]).show();
    		$("#links").html(array[1]);
    		}

    	});
			 
		});

		


		$(".yesorno").on("change", function(){
        		yesornoValue = $(this).val()
        		var dataSelector = $("#dataSelector").val();
        		$("#dataTable tbody").hide();
        			switch(yesornoValue) {
    				case "No":
    				console.log("yesornovalue = " + yesornoValue + ", globalValue = " + globalValue + ", min = " + min);
    				console.log("min = " + min + ", inputValue = " + inputValue + ", get = " + get);
    				$.ajax({
			  			method: "POST",
			  			url: "ajax/Getdata.php",
			  			context: this,
			  			data: { column: globalValue, value: inputValue, completed: yesornoValue, min:min, max:max, get:1},
						success: function( msg ) {
			    		var array = msg.split("||");
    					$("#dataTable tbody").html(array[0]).show();
    					$("#links").html(array[1]);
			    		}
			    	});

       				break;

    				case "Yes":
    				console.log("yesornovalue = " + yesornoValue + ", globalValue = " + globalValue + ", min = " + min);
    				console.log("min = " + min + ", inputValue = " + inputValue + ", get = " + get);
    				$.ajax({
			  			method: "POST",
			  			url: "ajax/Getdata.php",
			  			context: this,
			  			data: { column: globalValue, value: inputValue, completed: yesornoValue, min:min, max:max, get:1},
						success: function( msg ) {
			    		var array = msg.split("||");
    					$("#dataTable tbody").html(array[0]).show();
    					$("#links").html(array[1]);
			    		}	
			    	});
    				
        			break;
    				
    				default:
    				console.log("yesornovalue = " + yesornoValue + ", globalValue = " + globalValue + ", min = " + min);
    				console.log("min = " + min + ", inputValue = " + inputValue + ", get = " + get);
    				$.ajax({
			  			method: "POST",
			  			url: "ajax/Getdata.php",
			  			context: this,
			  			data: { column: globalValue, value: inputValue, completed: yesornoValue, min:min, max:max, get:1},
						success: function( msg ) {
			    		var array = msg.split("||");
    					$("#dataTable tbody").html(array[0]).show();
    					$("#links").html(array[1]);
			  			
		  				}
  					})
    				
        		};
        });
		var id;
		$(".id")
			.on("mouseenter", function(){
				sum = 0;
				id = $(this).text();
				$(this).html(tableButtons);
				
			})
			.on("mouseleave", function(){
				$(this).text(id);
				//console.log(text);
			});

		$(".id").on("click","#delete", function(){
				sum = 0;
				//needs to store it in a variable here, else it doesn't works with confirm!
				tr=$(this).closest("tr");
				if(confirm("Are you sure???")){
				$.ajax({
	  			method: "POST",
	  			url: "ajax/Delete.php",
	  			context: this,
	  			data: { id: id },
				success: function( msg ) {
	    		tr.hide();
	    		$("#fixed").html(msg).show().delay(5000).fadeOut();
	  			commissionOutcome();
  				}
  			})
		}
		});

		$(".id").siblings().on("dblclick", function(){
			var text = $(this).text();
			if($(this).hasClass("Commission")) {
				alert("Don't try to change commission manualy, change amount ot margin instead");
			}
			else if($(this).hasClass("Completed")) {

				var edit = '<select id="completedYesNo">';
    				edit +=	'<option value="Yes" selected>Yes</option><option value="No">No</option>';
    				edit += '</select>';
    			$(this).html(edit);
    			$("#completedYesNo").focus();
			}
			else {
				var edit = '<input type="text" name="edit" id="edit" value="'+ text + '">';
				$(this).html(edit);
			$("#edit").focus();
			}
		});

		$("tr").on("blur", "#completedYesNo", function(){
			var value = $(this).closest("td").find("select").val();
			var id = $(this).closest("tr").find(".id").text();
			var parent = $(this).parent();

			$.ajax({
	  			method: "POST",
	  			url: "ajax/Edit.php",
	  			context: this,
	  			data: { id: id, value: value, column: "Completed" },
				success: function( msg ) {
					$("#fixed").html(msg).show().delay(5000).fadeOut();
	    			parent.text(value);
	  			
  				}
  			})

			
		});

		$("tr").on("blur", "#edit", function(){
			var value = $(this).val();
			var amount = $(this).closest("tr").find(".Amount").text();
			var margin = $(this).closest("tr").find(".Margin").text();
			var Commission = $(this).closest('tr').find(".Commission");
			var id = $(this).closest("tr").find(".id").text();
			
			sum = 0;
			var parent = $(this).parent();
			
			var className = parent.attr("class");
			$(this).parent().text(value);
			var commissionValue = Commission.text();

			if(parent.hasClass("Amount")) {
				commissionValue = Number(value)*Number(margin)
				Commission.text(commissionValue);
				commissionOutcome();
			}

			if(parent.hasClass("Margin")) {
				commissionValue = Number(value)*Number(amount);
				Commission.text(commissionValue);
				commissionOutcome();
			}

			//alert(className);
			
			$.ajax({
	  			method: "POST",
	  			url: "ajax/Edit.php",
	  			context: this,
	  			data: { id: id, value: value, column: className, commission: commissionValue },
				success: function( msg ) {
					$("#fixed").html(msg).show().delay(5000).fadeOut();
	    			$(this).parent().text(value);
	  			
  				}
  			})
		});
    		
    		$("#dataSelector").on("change", function() {
    			sum = 0;
    			//commissionOutcome();
    			$("#dataTable td, #dataTable th").css("background-color", "white");
    			globalValue = $(this).val();
    			//alert(globalValue)
    			if(globalValue === "Choose...")
    				{
    					$(".search").hide();
    					return;
    				}
    			else {
    				var me = $("#by" + globalValue);
    				me.show();
    				me.siblings("div").hide();
    				}

    			$("#searchBy" + globalValue).keyup(function(){
    				$("#dataTable tbody").hide();
    				inputValue = $(this).val();
    				console.log("yesornovalue = " + yesornoValue + ", globalValue = " + globalValue + ", min = " + min);
    				console.log("min = " + min + ", inputValue = " + inputValue + ", get = " + get);
					$.ajax({
			  			method: "POST",
			  			url: "ajax/Getdata.php",
			  			context: this,
			  			data: { column: globalValue, value: inputValue, completed: yesornoValue, min: 0, max: 0, get:1},
						success: function( msg ) {
			    		var array = msg.split("||");
    					$("#dataTable tbody").html(array[0]).show();
    					$("#links").html(array[1]);
			    		}
			    	});
				});

				$("#searchBy" + globalValue).change(function(){
    				$("#dataTable tbody").hide();
    				inputValue = $(this).val();
    				console.log("yesornovalue = " + yesornoValue + ", globalValue = " + globalValue + ", min = " + min);
    				console.log("min = " + min + ", inputValue = " + inputValue + ", get = " + get);
					$.ajax({
			  			method: "POST",
			  			url: "ajax/Getdata.php",
			  			context: this,
			  			data: { column: globalValue, value: inputValue, completed: yesornoValue, min:0, max:0, get:1},
						success: function( msg ) {
			    		var array = msg.split("||");
    					$("#dataTable tbody").html(array[0]).show();
    					$("#links").html(array[1]);
			    		}
			    	});
				});

				$("#min" + globalValue).keyup(function(){
    				$("#dataTable tbody").hide();
    				min = $(this).val();
    				max = $("#max" + globalValue).val();
    				console.log("yesornovalue = " + yesornoValue + ", globalValue = " + globalValue + ", min = " + min);
    				console.log("min = " + min + ", inputValue = " + inputValue + ", get = " + get);
					$.ajax({
			  			method: "POST",
			  			url: "ajax/Getdata.php",
			  			context: this,
			  			data: { column: globalValue, value:"", completed: yesornoValue, min: min, max: max, get:1},
						success: function( msg ) {
			    		var array = msg.split("||");
    					$("#dataTable tbody").html(array[0]).show();
    					$("#links").html(array[1]);
			    		}
			    	
			    	});
			    	
				});

				$("#max" + globalValue).keyup(function(){
    				$("#dataTable tbody").hide();
    				min = $("#min" + globalValue).val();
    				max = $(this).val();
    				console.log("yesornovalue = " + yesornoValue + ", globalValue = " + globalValue + ", min = " + min);
    				console.log("min = " + min + ", inputValue = " + inputValue + ", get = " + get);
					$.ajax({
			  			method: "POST",
			  			url: "ajax/Getdata.php",
			  			context: this,
			  			data: { column: globalValue, value:"", completed: yesornoValue, min: min, max: max, get:1},
						success: function( msg ) {
			    		var array = msg.split("||");
    					$("#dataTable tbody").html(array[0]).show();
    					$("#links").html(array[1]);
			    		}
			    	
			    	});
			    	
				});


    			});
	    	
	    			
        	

        	function commissionOutcome() {
				$(".Commission:visible").each(function(){
    				var commission = Number($(this).text());
    				sum += commission;
    			});
    			$("#sum").text(sum.toFixed(2));
    			
    		}
			
    		function sumOfCommission(commission) {

    			sum += commission;
    			$("#sum").text(sum.toFixed(2));

    		}

    		//counts commission
			
    		$("#margin").on("blur", function() {
    			var amount = $("#amount").val();
    			var margin = $("#margin").val();

    			var commission = (amount * margin).toFixed(2); 

    			$("#commission").val(commission);
    		});

    		$(".message").delay(5000).fadeOut();

		
    		
    		
    			
    			
    		

});
		
        	

        	
        	
        	




    
    		

        
    
    