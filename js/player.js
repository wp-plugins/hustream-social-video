(function() {
    tinymce.create('tinymce.plugins.hustream_embed', {
        init : function(ed, url) {
            ed.addButton('hustream_embed', {
                title : 'Hustream Embed',
                image : url+'/icon.png',
                onclick : function() {
                   ed.windowManager.open({
                                        file : url + '/popup.php',
                                        width : 400 + ed.getLang('example.delta_width', 0),
                                        height : 260 + ed.getLang('example.delta_height', 0),
                                        inline : 1
                                }, {
                                        plugin_url : url, // Plugin absolute URL
                                        //some_custom_arg : 'custom arg' // Custom argument
                                });
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('hustream_embed', tinymce.plugins.hustream_embed);
})();



