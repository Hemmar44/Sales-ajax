$(function(){
	//sum on other than name and product;
		var yesornoValue = $(".yesorno:checked").val();
		var globalValue;
		var sum = 0;
		var tableButtons = '</button><button type="button" id="delete" class="btn btn-warning btn-sm">Delete</button>'

		commission();

		//edit delete
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
	  			commission();
  				}
  			})
		}
		});

		$(".id").siblings().on("dblclick", function(){
			var text = $(this).text();
			if($(this).hasClass("Commission")) {
				alert("Don't try to change commission manualy, change amount ot margin instead");
			}
			else {
			var edit = '<input type="text" name="edit" id="edit" value="'+ text + '">';
			$(this).html(edit);
			$("#edit").focus();
			}
		});

		$("tr").on("blur", "#edit", function(){
			var value = $(this).val();
			var amount = $(this).closest("tr").find(".Amount").text();
			var margin = $(this).closest("tr").find(".Margin").text();
			var Commission = $(this).closest('tr').find(".Commission");
			var id = $(this).closest("tr").find(".id").text();
			
			sum = 0;
			var parent = $(this).parent();
			parent.text(value);
			var className = parent.attr("class");
			$(this).parent().text(value);
			var commissionValue = Commission.text();

			if(parent.hasClass("Amount")) {
				commissionValue = Number(value)*Number(margin)
				Commission.text(commissionValue);
				commission();
			}

			if(parent.hasClass("Margin")) {
				commissionValue = Number(value)*Number(amount);
				Commission.text(commissionValue);
				commission();
			}

			//alert(className);
			
			$.ajax({
	  			method: "POST",
	  			url: "ajax/Edit.php",
	  			context: this,
	  			data: { id: id, value: value, column: className, commission: commissionValue },
				success: function( msg ) {
					$("#fixed").html(msg).show().delay(5000).fadeOut();
	    		
	  			
  				}
  			})
		});
		
		//yes or no
		$(".yesorno").on("change", function(){
				alert(globalValue);
        		yesornoValue = $(this).val()
        		var dataSelector = $("#dataSelector").val();
        		
        		
        		if(dataSelector==="Product" || dataSelector==="Advisor" || dataSelector === "Date") {
        			
        			$("#searchBy" + dataSelector).val("Choose...").css("color", "red");
        		
        		}

        		else {

        			$("#searchBy" + dataSelector).css("color", "red");
        			$("#min" + dataSelector).css("color", "red");
        			$("#max" + dataSelector).css("color", "red");

        		}
       			
       				 	

        		switch(yesornoValue) {
    				case "No":
    				
       				 $(".Completed").each(function(index, element){
       				 	if($(element).text() !== yesornoValue) {
       				 		$(element).closest("tr").hide();
       				 	}
       				 	if($(element).text() === yesornoValue) {
       				 		$(element).closest("tr").show();
       				 	}

       				 	
       				 	
       				 });
       				break;
    				case "Yes":
    				
        			 $(".Completed").each(function(index, element){
       				 	if($(element).text() !== yesornoValue) {
       				 		$(element).closest("tr").hide();
       				 	}
       				 	if($(element).text() === yesornoValue) {
       				 		$(element).closest("tr").show(); 
       				 	}
       				 });
        			break;
    				default:
    				
        			 $(".Completed").each(function(index, element){
       				 	$(element).closest("tr").show();
       				 });
        	};
        });
		
    	//search engine
    		
    		$("#dataSelector").on("change", function() {
    			sum = 0;
    			commission();
    			$("#dataTable td, #dataTable th").css("background-color", "white");
    			globalValue = $(this).val();
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

    	//search by name or institution
    			if(globalValue ==="Name" || globalValue==="Institution"){
	    			$("#searchBy" + globalValue).on("keyup", function(){
	    			$(this).css("color", "#000");
	    			var value = $(this).val();
	    			var lower = globalValue.toLowerCase();
	    			sum = 0;
	    			$("." + lower).css("background-color", "#E8E8E8");
	    			$("#dataTable tbody").find("tr").hide();

	    				$("#dataTable ." + globalValue)
	    					.css("background-color", "#E8E8E8")
	    					.each(function (index, element) {
			        			var text = $(this).text();
			        			var completed = $(element).closest("tr").find(".Completed").text();
			        			var commission = 0
			        				//alert("before if" + commission);
					        		//alert(sum);
			        				if(yesornoValue === "Yes" || yesornoValue === "No") {
					        			if(text.includes(value) && completed === yesornoValue) {
					        				commission = Number($(element).closest("tr").find(".Commission").text());
					     					$(element).closest("tr").show();
					     					}
					     				else {
					     					
					     					commission = 0;
					     					
					     					}
					     			sumOfCommission(commission);

					     			//sum += commission;
					     			//$("#sum").text(sum);

					        			}

					        		if(yesornoValue==="All") {
					        			if(text.includes(value))
					        			{
					        				commission = Number($(element).closest("tr").find(".Commission").text());
					        				$(element).closest("tr").show();
					        				
					        			}
					        			else {

					        				commission = 0
					        			}

					        		sumOfCommission(commission);
					        		//sum += commission;
					        		//$("#sum").text(sum);

									}
									
					        			
				        			
			        			
		        				
		        		});
		        	});
    			}	
    		//search by product, advisor, month
    			else if(globalValue === "Product" || globalValue === "Advisor" || globalValue === "Date") {
	        		$("#searchBy" + globalValue).on("change", function(){
	        		$(this).css("color", "#000");
	        		var value = $(this).val();
	        		var lower = globalValue.toLowerCase();
	        		sum = 0;
	    			$("." + lower).css("background-color", "#E8E8E8");
	    			$("#dataTable tbody").find("tr").hide();
	    				$("#dataTable ." + globalValue)
	    					.css("background-color", "#E8E8E8")
	    					.each(function (index, element) {
			        			var text = $(this).text();
			        			var commission = 0;
			        			var completed = $(element).closest("tr").find(".Completed").text();
			        			if(yesornoValue === "Yes" || yesornoValue === "No") {
				        			if(text===value && completed === yesornoValue) {
				        				commission = Number($(element).closest("tr").find(".Commission").text());
				        				$(element).closest("tr").show();
			        				}
			        				else
			        					commission = 0 
			        			}

			        			sumOfCommission(commission);

			        			if(yesornoValue==="All") {
				        			if(text===value)
				        			{
				        			commission = Number($(element).closest("tr").find(".Commission").text());
				        			$(element).closest("tr").show();

				        			}
				        			else {
				        				commission = 0
				        			}

				        			sumOfCommission(commission);

					        	}
		        		});
		        	});
        		}
        	//search by Amount, Margin, Commission
        		else if(globalValue==="Amount" || globalValue==="Margin" || globalValue==="Commission") {
        			
        			var min = $("#min" + globalValue).val();       			
        			var max = $("#max" + globalValue).val();
       				var lower = globalValue.toLowerCase();
	    			
        			$("#min" + globalValue).on("keyup", function(){
        				$(this).css("color", "#000");
        				$("#max" + globalValue).css("color", "black");
        				$("#dataTable tbody").find("tr").hide();
        				$("." + lower).css("background-color", "#E8E8E8");
        				sum = 0;
        				min = $(this).val();
        				$("#dataTable ." + globalValue)
        					.css("background-color", "#E8E8E8")
        					.each(function (index, element) {
			        			var text = $(this).text();
			        			var commission = 0
			        			var completed = $(element).closest("tr").find(".Completed").text();
			        			if(yesornoValue === "Yes" || yesornoValue === "No") {
				        			if(Number(text)>=Number(min) && Number(text)<=Number(max) && completed === yesornoValue) {
				        				commission = Number($(element).closest("tr").find(".Commission").text());
				        				$(element).closest("tr").show();
			        				}
			        				else {
			        					commission = 0;
			        				}

			        				sumOfCommission(commission);

		        				}
		        				if(yesornoValue === "All") {
		        					if(Number(text)>=Number(min) && Number(text)<=Number(max)) {
		        						commission = Number($(element).closest("tr").find(".Commission").text());
				        				$(element).closest("tr").show();
			        				}
			        				else {
			        					commission = 0;
			        				}

			        				sumOfCommission(commission);
		        				}
        				});
        			});

        			$("#max" + globalValue).on("keyup", function(){
						$("#dataTable tbody").find("tr").hide();
						$(this).css("color", "#000");
        				$("#min" + globalValue).css("color", "black");
						$("." + lower).css("background-color", "#E8E8E8");
						sum = 0 
        				max = $(this).val();
        				$("#dataTable ." + globalValue)
        					.css("background-color", "#E8E8E8")
        					.each(function (index, element) {
			        			var text = $(this).text();
			        			commission = 0
			        			var completed = $(element).closest("tr").find(".Completed").text();
			        			if(yesornoValue === "Yes" || yesornoValue === "No") {
				        			if(Number(text)>=Number(min) && Number(text)<=Number(max) && completed === yesornoValue) {
				        				commission = Number($(element).closest("tr").find(".Commission").text());
				        				$(element).closest("tr").show();
			        				}
			        				else {
			        					commission = 0; 
			        				}

			        				sumOfCommission(commission);
									}
			        				if(yesornoValue === "All") {
			        					commission = Number($(element).closest("tr").find(".Commission").text());
			        					if(Number(text)>=Number(min) && Number(text)<=Number(max)) {
					        				commission = Number($(element).closest("tr").find(".Commission").text());
					        				$(element).closest("tr").show();
			        				}
			        				else{
			        					commission = 0
			        				}
			        				sumOfCommission(commission);
		        				}




        				});
        			});
        			
        		}
        	});
        	//yes or no

        	function commission() {
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
		
        	



    
    		

        
    
    