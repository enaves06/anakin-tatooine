Ext.define('CGP.view.ConfiguracaoGridPanel', {
    extend: 'Ext.grid.Panel',
    xtype: 'configuracaogridpanel',
    
    initComponent: function() {
        var me = this;
        
        Ext.define('CGP.model.ConfiguracaoGridPanel', {
            extend: 'Ext.data.Model',
            fields: [
                {name: 'idEmpresa', type: 'integer'},
                {name: 'nomeEmpresa', type: 'string'},
                {name: 'idMarca', type: 'integer'},
                {name: 'idPessoa', type: 'integer'},
                {name: 'nomePessoa', type: 'string'},
                {name: 'idCondPagto', type: 'integer'},
                {name: 'descricaoCondPagto', type: 'string'},
                {name: 'idTransportadora', type: 'integer'},
                {name: 'nomeTransportadora', type: 'string'},
                {name: 'frete', type: 'string'}
            ]
        });

        var store = Ext.create('Ext.data.Store', {

            extend: 'Ext.data.Store',
            model: 'CGP.model.ConfiguracaoGridPanel',
            proxy: {
                type: 'ajax',
                api: {
                    read: baseUrl + '/app/cgp/configuracaomarcacomplemento/configuracao/listar',
                    update: baseUrl + '/app/cgp/configuracaomarcacomplemento/configuracao/alterar'
                },
                reader: {
                    type: 'json',
                    root: 'data',
                    successProperty: 'success'
                },
                writer: {
                    type: 'json',
                    writeAllFields: true,
                    encode: true,
                    root: 'data'
                },
                listeners:{
                    exception: function(proxy, response, operation){
                        Ext.MessageBox.show({
                            title: 'Remove exception',
                            msg: operation.getError(),
                            icon: Ext.MessageBox.ERROR,
                            buttons: Ext.Msg.OK
                        });
                    }
                }
            }
        });

        var condPagtoStore = Ext.create('Ext.data.Store', {
            autoLoad: true,
            proxy: {
                type: 'ajax',
                url: baseUrl + '/app/cgp/configuracaomarcacomplemento/configuracao/listarcondpagto',
                reader: {
                    type: 'json',
                    totalProperty: 'totalData',
                    root: 'data'
                }
            },
            fields: [
               {name: 'idCondPagto'}, {name: 'descricaoCondPagto'}
            ]
        });
        
        var transportadoraStore = Ext.create('Ext.data.Store', {
            autoLoad: false,
            proxy: {
                type: 'ajax',
                url: baseUrl + '/app/cgp/configuracaomarcacomplemento/transportadora/listar',
                reader: {
                    type: 'json',
                    totalProperty: 'totalData',
                    root: 'data'
                }
            },
            fields: [
               {name: 'id_empresa'}, {name: 'idTransportadora'}, {name: 'descricaoTransportadora'}
            ]
        });

        var freteStore = Ext.create('Ext.data.Store', {
            fields: ['idFrete', 'descricao'],
            data : [
                {idFrete: 'S', descricao: 'S'},
                {idFrete: 'N', descricao: 'N'}
            ]
        });   

        Ext.applyIf(me, {
            multiSelect: true,
            store: store,
            dockedItems: me.buildDockedItems(),
            columns: [
                {
                    text: 'EMPRESA',  
                    dataIndex: 'nomeEmpresa', 
                    width: 150
                },
                {
                    text: 'CNPJ',  
                    dataIndex: 'idPessoa', 
                    width: 150
                },
                {
                    text: 'FORNECEDOR',  
                    dataIndex: 'nomePessoa', 
                    flex: 1
                },
                {
                    text: 'CONDIÇÂO PAGAMENTO',  
                    dataIndex: 'descricaoCondPagto', 
                    width: 160,
                    editor: {
                        xtype: 'combobox',
                        name: 'cond_pagto',
                        store: condPagtoStore ,
                        queryMode: 'local',
                        displayField: 'descricaoCondPagto',
                        valueField: 'idCondPagto',
                        emptyText: 'Selecione uma cond. pagt.'
                    }
                },
                {
                    text: 'TRANSPORTADORA',  
                    dataIndex: 'nomeTransportadora', 
                    flex: 1,
                    editor: {
                        xtype: 'combobox',
                        name: 'transportadora',
                        store: transportadoraStore,
                        queryMode: 'local',
                        displayField: 'descricaoTransportadora',
                        valueField: 'idTransportadora',
                        emptyText: 'Selecione um transportadora'
                    }
                },
                {
                    text: 'FRETE',  
                    dataIndex: 'frete', 
                    width: 70,
                    editor: {
                        xtype: 'combobox',
                        name: 'frete',
                        store: freteStore,
                        queryMode: 'local',
                        displayField: 'descricao',
                        valueField: 'idFrete',
                        emptyText: 'Frete'
                    }
                }
            ],
            bbar: {
                xtype: 'pagingtoolbar',
                store: store,
                displayInfo: true,
                emptyMsg: "Sem registos para exibir"
            },
            plugins: [
                Ext.create('Ext.grid.plugin.RowEditing', {
                    clicksToEdit: 2
                })
            ],
        });
        
        me.callParent(arguments);
    },

    buildDockedItems: function(){
        var me = this;
        
        var empresaStore = Ext.create('Ext.data.Store', {
            autoLoad: false,
            proxy: {
                type: 'ajax',
                url: baseUrl + '/app/cgp/configuracaomarcacomplemento/empresa/listar',
                reader: {
                    type: 'json',
                    totalProperty: 'totalData',
                    root: 'data'
                }
            },
            fields: [
               {name: 'idEmpresa'}, {name: 'nomeEmpresa'}
            ]
        });
        
        

        var items = [{
            xtype: 'toolbar',
            dock: 'top',
            items: [
                {
                    xtype: 'toolbar',
                    ui: 'footer',
                    items: [
                        {
                            xtype: 'button',
                            text: 'Inserir',
                            action: 'inserir'
                        },
                        {
                            xtype: 'button',
                            text: 'Excluir',
                            action: 'excluir',
                            disabled: true
                        }
                    ]
                }
            ]
        }];
    
        return items;
    }

});