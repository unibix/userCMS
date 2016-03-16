/**
 * Controls: Table plugin
 * 
 * Depends on jWYSIWYG
 */
(function ($) {
	"use strict";

	if (undefined === $.wysiwyg) {
		throw "wysiwyg.table.js depends on $.wysiwyg";
	}

	if (!$.wysiwyg.controls) {
		$.wysiwyg.controls = {};
	}

	var insertTable = function (tableOpts, filler) {
		if (isNaN(tableOpts.colCount) || isNaN(tableOpts.rowCount) || tableOpts.rowCount === null || tableOpts.colCount === null) {
			return;
		}

		var colCount = parseInt(tableOpts.colCount, 10);
		var rowCount = parseInt(tableOpts.rowCount, 10);
		var border = parseInt(tableOpts.border);
		var cellpadding = parseInt(tableOpts.cellpadding);
		var collapse = parseInt(tableOpts.collapse);
		
		var style = 'width: 100%; border-collapse: ';
		
		if (collapse) {
			style += 'collapse;';
		} else {
			style += 'separate;';
		}
		
		var i, j, html = ['<table cellpadding="' + cellpadding + '" border="' + border + '" style="' + style + '"><tbody>'];

		if (filler === null) {
			filler = "&nbsp;";
		}
		filler = "<td>" + filler + "</td>";

		for (i = rowCount; i > 0; i -= 1) {
			html.push("<tr>");
			for (j = colCount; j > 0; j -= 1) {
				html.push(filler);
			}
			html.push("</tr>");
		}
		html.push("</tbody></table>");

		return this.insertHtml(html.join(""));
	};

	/*
	 * Wysiwyg namespace: public properties and methods
	 */
	$.wysiwyg.controls.table = function (Wysiwyg) {
		var adialog, dialog, colCount, rowCount, formTableHtml, dialogReplacements, key, translation, regexp;

		dialogReplacements = {
			legend: "Insert table",
			cols  : "Количество столбцов",
			rows  : "Количество строк",
			border : "Толщина границы",
			cellpadding : "Отступ внутри ячейки",
			collapse : "Объеденить границы ячеек",
			submit: "Вставить таблицу",
			reset: "Отмена"
		};

		formTableHtml = '<form class="wysiwyg" id="wysiwyg-tableInsert"><fieldset><legend>{legend}</legend>' +
			'<label>{cols}: <input type="text" name="colCount" value="3" /></label><br/>' +
			'<label>{border}: <input type="text" name="border" value="1" /></label><br/>' +
			'<label>{cellpadding}: <input type="text" name="cellpadding" value="0" /></label><br/>' +
			'<label>{collapse}: <input type="checkbox" name="collapse" value="1" checked /></label><br/>' +
			'<label>{rows}: <input type="text" name="rowCount" value="3" /></label><br/>' +
			'<input type="submit" class="button" value="{submit}"/> ' +
			'<input type="reset" value="{reset}"/></fieldset></form>';
		
		for (key in dialogReplacements) {
			if ($.wysiwyg.i18n) {
				translation = $.wysiwyg.i18n.t(dialogReplacements[key], "dialogs.table");

				if (translation === dialogReplacements[key]) { // if not translated search in dialogs 
					translation = $.wysiwyg.i18n.t(dialogReplacements[key], "dialogs");
				}

				dialogReplacements[key] = translation;
			}

			regexp = new RegExp("{" + key + "}", "g");
			formTableHtml = formTableHtml.replace(regexp, dialogReplacements[key]);
		}

		if (!Wysiwyg.insertTable) {
			Wysiwyg.insertTable = insertTable;
		}

		adialog = new $.wysiwyg.dialog(Wysiwyg, {
			"title"   : dialogReplacements.legend,
			"content" : formTableHtml,
			"open"    : function (e, dialog) {
				dialog.find("form#wysiwyg-tableInsert").submit(function (e) {
					e.preventDefault();
					
					var tableOpts = {
						rowCount: dialog.find("input[name=rowCount]").val(),
						colCount: dialog.find("input[name=colCount]").val(),
						border: dialog.find("input[name=border]").val(),
						cellpadding: dialog.find("input[name=cellpadding]").val(),
						collapse: dialog.find("input[name=collapse]:checked").length,
					}
					
					rowCount = dialog.find("input[name=rowCount]").val();
					colCount = dialog.find("input[name=colCount]").val();

					Wysiwyg.insertTable(tableOpts, Wysiwyg.defaults.tableFiller);
					// Wysiwyg.insertTable(colCount, rowCount, Wysiwyg.defaults.tableFiller);

					adialog.close();
					return false;
				});

				dialog.find("input:reset").click(function (e) {
					e.preventDefault();
					adialog.close();
					return false;
				});
			}
		});
		
		adialog.open();

		$(Wysiwyg.editorDoc).trigger("editorRefresh.wysiwyg");
	};

	$.wysiwyg.insertTable = function (object, tableOpts, filler) {
		return object.each(function () {
			var Wysiwyg = $(this).data("wysiwyg");

			if (!Wysiwyg.insertTable) {
				Wysiwyg.insertTable = insertTable;
			}

			if (!Wysiwyg) {
				return this;
			}

			Wysiwyg.insertTable(tableOpts, filler);
			$(Wysiwyg.editorDoc).trigger("editorRefresh.wysiwyg");

			return this;
		});
	};
})(jQuery);
