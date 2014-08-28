Ext.define('CGP.view.configuracao.FornecedorGridPanel', {
    extend: 'Ext.grid.Panel',
    xtype: 'configuracao-fornecedorgridpanel',
    
    initComponent: function() {
        var me = this;
        
        Ext.define('CGP.model.FornecedorGridPanel', {
            extend: 'Ext.data.Model',
            fields: [
                {name: 'idPessoa', type: 'integer'},
                {name: 'nomeFornecedor', type: 'string'}
            ]
        });

        var store = Ext.create('Ext.data.Store', {
            extend: 'Ext.data.Store',
            model: 'CGP.model.FornecedorGridPanel',
            proxy: {
                type: 'ajax',
                url: baseUrl + '/app/cgp/configuracaomarcacomplemento/fornecedor/listar',
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
                    text: 'CNPJ',  
                    dataIndex: 'idPessoa', 
                    width: 200
                },
                {
                    text: 'Fornecedor',  
                    dataIndex: 'nomeFornecedor', 
                    flex: 1
                }
            ]
        });
        
        me.callParent(arguments);
    }

});