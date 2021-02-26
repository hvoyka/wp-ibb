(function() {
  tinymce.PluginManager.add('ibb_mce_button', function(editor, url) {
      editor.addButton('ibb_mce_button', {
          icon: false,
          text: "IBB",
          onclick: function() {
              editor.windowManager.open({
                  title: "Insert Inline Banner",
                  body: [{
                      type: 'textbox',
                      name: 'ibb_id',
                      label: 'Post id',
                      value: ''
                  },
                  {
                      type: 'textbox',
                      name: 'ibb_text',
                      label: 'Name',
                      value: ''
                  },
                                   
                 ],
                  onsubmit: function(e) {
                      editor.insertContent(
                          '[ibb posts="' +
                          e.data.ibb_id + 
                          '" name="' +
                          e.data.ibb_text + 
                           
                          '"]'
                      );
                  }
              });
          }
      });
  });
})();