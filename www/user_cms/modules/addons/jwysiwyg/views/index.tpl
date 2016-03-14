        <script type="text/javascript">
          $(function() {
            $('.wysiwyg').wysiwyg({
              initialContent : '',
              formHeight: 400,
              controls: {
                  increaseFontSize: { visible: true },
                  decreaseFontSize: { visible: true },
                  colorpicker: {
                          groupIndex: 11,
                          visible: true,
                          css: {
                                  "color": function (cssValue, Wysiwyg) {
                                          var document = Wysiwyg.innerDocument(),
                                                  defaultTextareaColor = $(document.body).css("color");

                                          if (cssValue !== defaultTextareaColor) {
                                                  return true;
                                          }

                                          return false;
                                  }
                          },
                          exec: function() {
                                  if ($.wysiwyg.controls.colorpicker) {
                                          $.wysiwyg.controls.colorpicker.init(this);
                                  }
                          },
                          tooltip: "Colorpicker"
                  },
                  fileMngr: {visible: true}
              },
              formWidth: 'auto'
            });
          });

          $.wysiwyg.fileManager.setAjaxHandler('<?php echo $handler_url; ?>')
        </script>
        <style type="text/css">
          #content textarea.wysiwyg {background: #FFFFFF; border: 0 none; border-radius: 0; height: 400px; padding: 0; width: 100%;}
          
        </style>