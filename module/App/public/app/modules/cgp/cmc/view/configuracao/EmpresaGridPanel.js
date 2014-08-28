Ext.define('CGP.view.configuracao.EmpresaGridPanel', {
    extend: 'Ext.grid.Panel',
    xtype: 'configuracao-empresagridpanel',
    
    initComponent: function() {
        var me = this;
        
        Ext.define('CGP.model.EmpresaGridPanel', {
            extend: 'Ext.data.Model',
            fields: [
                {name: 'idEmpresa', type: 'integer'},
                {name: 'nomeEmpresa', type: 'string'}
            ]
        });

        var store = Ext.create('Ext.data.Store', {
            extend: 'Ext.data.Store',
            model: 'CGP.model.EmpresaGridPanel',
            proxy: {
                type: 'ajax',
                url: baseUrl + '/app/cgp/configuracaomarcacomplemento/empresa/listar',
                timeout: 60000,
                reader: {
                    type: 'json',
                    root: 'data'
                }
            }
        });

        Ext.applyIf(me, {
            store: store,
            hideHeaders : true,
            multiSelect: true,
            columns: [
                {
                    text: 'Empresa',  
                    dataIndex: 'nomeEmpresa', 
                    flex: 1
                }
            ]
        });
        
        me.callParent(arguments);
    }

});