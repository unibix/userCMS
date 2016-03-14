/**
 * Controls: Link plugin
 *
 * Depends on jWYSIWYG
 *
 * By: Esteban Beltran (academo) <sergies@gmail.com>
 */
 
(function ($) {
	"use strict";

	if (undefined === $.wysiwyg) {
		throw "wysiwyg.link.js depends on $.wysiwyg";
	}

	if (!$.wysiwyg.controls) {
		$.wysiwyg.controls = {};
	}

	/*
	* Wysiwyg namespace: public properties and methods
	*/
	$.wysiwyg.controls.createMsWordPopup = {
		init: function (Wysiwyg) {
			var self = this, elements, adialog, url, a, selection,
				formWordHtml, dialogReplacements, key, translation, regexp,
				baseUrl, img;

			dialogReplacements = {
				label: "Insert Ms Word Text",
				submit: "Format",
				reset: "Cancel",
				legend: "Paste From Word"
			};

			formWordHtml = '<form id="wysiwyg-msWordFormat" class="wysiwyg">' +
				'<label>{label}</label>' +
				'<div id="ms_word_content" style="border: 1px solid #666; width: 340px; height: 200px; overflow-y: scroll" contenteditable="true"></div>' +
				'<input type="submit" class="button" value="{submit}"/> ' +
				'<input type="reset" value="{reset}"/></form>';

			for (key in dialogReplacements) {
				if ($.wysiwyg.i18n) {
					translation = $.wysiwyg.i18n.t(dialogReplacements[key], "dialogs.link");

					if (translation === dialogReplacements[key]) { // if not translated search in dialogs 
						translation = $.wysiwyg.i18n.t(dialogReplacements[key], "dialogs");
					}

					dialogReplacements[key] = translation;
				}

				regexp = new RegExp("{" + key + "}", "g");
				formWordHtml = formWordHtml.replace(regexp, dialogReplacements[key]);
			}

			adialog = new $.wysiwyg.dialog(Wysiwyg, {
				"title"   : dialogReplacements.legend,
				"content" : formWordHtml
			});
			
			$(adialog).bind("afterOpen", function (e, dialog) {
				dialog.find("form#wysiwyg-msWordFormat").submit(function (e) {
					e.preventDefault();
					$.wysiwyg.removeMsWordFormatingPopup(dialog.container, Wysiwyg);

					adialog.close();
					return false;
				});

				// File Manager (select file):
				if ($.wysiwyg.fileManager) {
					$("div.wysiwyg-fileManager").bind("click", function () {
						$.wysiwyg.fileManager.init(Wysiwyg, function (selected) {
							dialog.find("input[name=src]").val(selected);
							dialog.find("input[name=src]").trigger("change");
						});
					});
				}

				$("input:reset", dialog).click(function (e) {
					adialog.close();

					return false;
				});

				$("fieldset", dialog).click(function (e) {
					e.stopPropagation();
				});

				// self.makeForm(dialog);
			});

			
			adialog.open();
		}
	};

	$.wysiwyg.removeMsWordFormatingPopup = function (context, Wysiwyg) {
		var wordText = $('#ms_word_content', context).html();
		// alert(Wysiwyg.CleanWordHTML(wordText));
		
		var Range = Wysiwyg.getInternalRange(),
			Selection = Wysiwyg.getInternalSelection();
		
		// очищаем
		var cleanedHtml = Wysiwyg.CleanWordHTML(wordText);
		alert(cleanedHtml);
		// ставим на место
		if (Range.createContextualFragment) {
			var node = Range.createContextualFragment(cleanedHtml);
		} else {
			// In IE 9 we need to use innerHTML of a temporary element
			var ie_div = document.createElement("div"), child;
			ie_div.innerHTML = cleanedHtml;
			var node = document.createDocumentFragment();
			while ( (child = ie_div.firstChild) ) {
				node.appendChild(child);
			}
		}
		
		Range.deleteContents();
		
		Range.insertNode(node);
		return;
	};
})(jQuery);