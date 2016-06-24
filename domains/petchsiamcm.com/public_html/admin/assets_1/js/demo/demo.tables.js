/*

 * Dandelion Admin v2.0 - Table Demo JS

 *

 * This file is part of Dandelion Admin, an Admin template build for sale at ThemeForest.

 * For questions, suggestions or support request, please mail me at maimairel@yahoo.com

 *

 * Development Started:

 * March 25, 2012

 * Last Update:

 * December 07, 2012

 *

 */



(function($) {

	$(document).ready(function(e) {

		$("table#da-ex-datatable-numberpaging").dataTable({

			sPaginationType: "full_numbers",

			"aLengthMenu": [

           		[5, 15, 20, 40, 80, -1],

            	[5, 15, 20, 40, 80, "All"] // change per page values here

       		],

       		// set the initial value

       		"iDisplayLength": 20,

		});		

		

		$("table#da-ex-datatable-sort").dataTable({

			sPaginationType: "full_numbers",

			"aaSorting": [[ $("table#da-ex-datatable-sort").attr("sort"), $("table#da-ex-datatable-sort").attr("order") ]],

			"aLengthMenu": [

           		[5, 15, 20, 40, 80, -1],

            	[5, 15, 20, 40, 80, "All"] // change per page values here

       		],

       		// set the initial value

       		"iDisplayLength": 20,

			"sScrollX": "100%",
			
			"sScrollY": "500px",

		});

		

		$("table#da-ex-datatable-default").dataTable();

	});

}) (jQuery);