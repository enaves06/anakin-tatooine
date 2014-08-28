Ext.Loader.setConfig({enabled: true, disableCaching: true});

Ext.application({
    name: 'CGP',
    autoCreateViewport: true,
    appFolder: '../../app/modules/cgp/cmc',
    requires:[
    
    ],
    paths: {
        'Ext.ux': '../../app/modules/cgp/cmc/ux'
    },
    controllers: [
        'Marca',
        'Configuracao',
        'Empresa'
    ],
    
    launch: function() { 
        var me = this;
    }
});