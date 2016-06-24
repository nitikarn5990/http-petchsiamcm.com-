/*
 * Dandelion Admin v2.0 - Form Demo JS
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
		if($.fn.autocomplete) {
			var availableTags = [
				"ActionScript",
				"AppleScript",
				"Asp",
				"BASIC",
				"C",
				"C++",
				"Clojure",
				"COBOL",
				"ColdFusion",
				"Erlang",
				"Fortran",
				"Groovy",
				"Haskell",
				"Java",
				"JavaScript",
				"Lisp",
				"Perl",
				"PHP",
				"Python",
				"Ruby",
				"Scala",
				"Scheme"
			];
			
			$( "#da-ex-autocomplete" ).autocomplete({
				source: availableTags
			});
		}
		
		$.fn.iButton && $(".i-button").iButton();
		
		$.fn.select2 && $(".select2-select").select2();

		$.fn.fileInput && $('.da-custom-file').fileInput();
	
		if($.fn.ColorPicker) {
			$("#da-ex-colorpicker").ColorPicker({
				onSubmit: function(hsb, hex, rgb, el) {
					$(el).val(hex);
					$(el).ColorPickerHide();
				}, 
				onBeforeShow: function () {
					$(this).ColorPickerSetColor(this.value);
				}
			});
		}
		
		$.fn.picklist && $("#da-ex-picklist").picklist();

        if( $.fn.spinner ) {

            $('.da-spinner').spinner();

            $('.da-decimal-spinner').spinner({
                step: 0.01,
                numberFormat: "n"
            });

            $.widget( "ui.timespinner", $.ui.spinner, {
                options: {
                    // seconds
                    step: 60 * 1000,
                    // hours
                    page: 60
                },
         
                _parse: function( value ) {
                    if ( typeof value === "string" ) {
                        // already a timestamp
                        if ( Number( value ) == value ) {
                            return Number( value );
                        }
                        return +Globalize.parseDate( value );
                    }
                    return value;
                },
         
                _format: function( value ) {
                    return Globalize.format( new Date(value), "t" );
                }
            });

            $( ".da-time-spinner" ).timespinner({
                value: new Date().getTime()
            });
		}

		if($.fn.autosize)
			$("#da-ex-autosize").autosize();
			
		if($.fn.elrte) {
			var opts = {
				cssClass : 'el-rte',
				height   : 300,
				toolbar  : 'normal',
				cssfiles : ['plugins/elrte/css/elrte-inner.css'], 
				fmAllow: true, 
				fmOpen : function(callback) {
					$('<div id="myelfinder"></div>').elfinder({
						url : 'plugins/elFinder_2_1/connectors/php/connector.php', 
						lang : 'en', 
						height: 300, /*
						toolbar : [
							['back', 'reload'], 
							['select', 'open'], 
							['quicklook', 'info', 'rename'], 
							['resize', 'icons', 'list', 'help']
						], 
						contextmenu : {
							// Commands that can be executed for current directory
							cwd : ['reload', 'delim', 'info'], 
							// Commands for only one selected file
							file : ['select', 'open', 'rename'], 
						}, */
						dialog : { width : 640, modal : true, title : 'Select Image' }, 
						closeOnEditorCallback : true,
						editorCallback : callback
					});
				}
				/*fmOpen : function(callback) {
					$('<div id="myelfinder"></div>').elfinder({
						url : 'plugins/elfinder/connectors/php/connector.php', 
						lang : 'en', 
						height: 300, 
						dialog : { width : 640, modal : true, title : 'Select Image' }, 
						closeOnEditorCallback : true,
						editorCallback : callback
					});
				}*/
			}
			$('.wysiwyg').elrte(opts);
		}
		
		tinyMCE.init({
			// General options
			selector: "textarea.tinymce",
			theme: "advanced",
			height : "350",
			plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
			// Theme options
			theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4: "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
			theme_advanced_toolbar_location: "top",
			theme_advanced_toolbar_align: "left",
			theme_advanced_statusbar_location: "bottom",
			theme_advanced_resizing: true,
			theme_advanced_resizing_use_cookie : false,
			file_browser_callback : 'elFinderBrowser',
			// Example content CSS (should be your site CSS)
			content_css: "assets/css/styletinymce.css",
			// Drop lists for link/image/media/template dialogs
			//template_external_list_url: "lists/template_list.js",
			//external_link_list_url: "lists/link_list.js",
			//external_image_list_url: "lists/image_list.js",
			//media_external_list_url: "lists/media_list.js",
			// Style formats
			/*style_formats: [
				{title: 'Bold text', inline: 'b'},
				{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
				{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
				{title: 'Example 1', inline: 'span', classes: 'example1'},
				{title: 'Example 2', inline: 'span', classes: 'example2'},
				{title: 'Table styles'},
				{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
			],*/
		});
		
	});
}) (jQuery);

function elFinderBrowser (field_name, url, type, win) {
    var elfinder_url = 'plugins/elfinder/elfindertmc.html';    // use an absolute path!
    tinyMCE.activeEditor.windowManager.open({
        file: elfinder_url,
        title: 'Files Manager',
        width: 1100,
        height: 430,
        resizable: 'yes',
        inline: 'yes',    // This parameter only has an effect if you use the inlinepopups plugin!
        popup_css: false, // Disable TinyMCE's default popup CSS
        close_previous: 'no'
    }, {
        window: win,
        input: field_name
    });
    return false;
}