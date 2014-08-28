Ext.define('CGP.view.MarcaGridPanel', {
    extend: 'Ext.grid.Panel',
    xtype: 'marcagridpanel',
    
    initComponent: function() {
        var me = this;
        
        Ext.define('CGP.model.MarcaGridPanel', {
            extend: 'Ext.data.Model',
            fields: [
                {name: 'idMarca', type: 'integer'},
                {name: 'descricaoMarca', type: 'string'}
            ]
        });

        var store = Ext.create('Ext.data.Store', {
            extend: 'Ext.data.Store',
            autoLoad: true,
            model: 'CGP.model.MarcaGridPanel',
            proxy: {
                type: 'ajax',
                url: baseUrl + '/app/cgp/configuracaomarcacomplemento/marca/listar',
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
            columns: [
                {
                    text: 'Marca',  
                    dataIndex: 'descricaoMarca', 
                    flex: 1
                }
            ]
        });
        
        me.callParent(arguments);
    }

});