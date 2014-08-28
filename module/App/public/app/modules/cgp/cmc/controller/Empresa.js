Ext.define('CGP.controller.Empresa', {
    extend: 'Ext.app.Controller',
    models: [       
    ],
    
    stores: [
    ],

    views: [
        'ConfiguracaoGridPanel'
    ],
    
    refs: [
        {
            ref: 'configuracaogridpanel',
            selector: 'configuracaogridpanel'
        }
    ],

    init: function() {
        var me = this;

        me.control({
            'configuracaogridpanel combobox[name=empresa]':{
                change: function(){
                    
                }
            }            
        });        
    },

    loadEmpresaCombobox: function(idMarca){
        var me = this;

        var params = {
            idMarca: idMarca
        };

        me.getConfiguracaogridpanel().down('toolbar').down('combobox[name=empresa]').getStore().load({params: params});
    }
});