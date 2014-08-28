Ext.define('CGP.controller.Marca', {
    extend: 'Ext.app.Controller',
    models: [       
    ],
    
    stores: [
    ],

    views: [
        'MarcaGridPanel'
    ],
    
    refs: [
        {
            ref: 'marcagridpanel',
            selector: 'marcagridpanel'
        }
    ],

    init: function() {
    	var me = this;

        me.control({
            'marcagridpanel': {
                itemclick: function(grid, record){
                    
                    me.getController('Configuracao').disableButtonExcluir();
                    me.listarConfiguracao(record.get('idMarca'));
                }
            }
        });        
    },

    listarConfiguracao: function(idMarca){
        var me = this;
        me.getController('Configuracao').loadConfiguracaoGridPanel(idMarca);
        me.getController('Empresa').loadEmpresaCombobox(idMarca);
    },

    recuperarMarca: function(){
        var me = this;
        var record = me.getMarcagridpanel().getSelectionModel().getLastSelected();
        
        return record.get('idMarca');
    }
});