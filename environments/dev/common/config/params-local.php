<?php
return [
    'websorType' => '{tipo istanza}', // Tipo istanza websor "regionale", "comunale", "sovracomunale", "provinciale"
    'view_sync_log' => false,
    'websorCitiesIstat' => '{codici istat comuni}', // Codici istat comuni per istanze comunali
    'showCartography' => false,
    'proxyUrl' => '',
    'laziocreaserver' => false,
    'adminEmail' => '{email admin}', // email amministratore
    'approvazioneElicotteroEmail' => '{email approvazioni elicottero}', // indirizzo ricevente richieste di approvazione elicotteri
    'feedbackApprovazioneElicotteroMail' => '{email feedback approvazioni elicottero}', // email ricevente feedback delle approvazioni degli elicotteri
    'coauMail' => '{indirizzo email Coau}', // indirizzo email del coau
    'coauMailCC' => '{indirizzo email CC Coau}', // indirizzo email in CC del coau
    'supportEmail' => '{indirizzo email supporto}', // indirizzo email del supporto
    'user.passwordResetTokenExpire' => '{scadenza token}', //es. 86400
    'audittrail.table' => 'tbl_audit_trail',
    'lat' => '{float: latitudine centro}', // latitudine di base delle mappe
    'lng' => '{float: latitudine centro}', // longitudine di base delle mappe
    'gmap_ne_latlng' => [
        'lat' => 44.02935859495429, // lat bbox nord est
        'lng' => 11.212921142578123, // lon bbox nord est
    ],
    'gmap_sw_latlng' => [
        'lat' => 42.79237748061047, // lat bbox sud ovest
        'lng' => 14.074859619140625, // lon bbox sud ovest
    ],
    'zoom' => '{int: livello base zoom}', // livello base zoom
    'APP_NAME' => '{Nome app}', // nome app mobile
    'REGION_NAME' => '{Nome regione}', // aggiunto per messaggio mail
    'MAIL_APP_SENDER' => '{Firma mail per app}', // Firma nel footer delle email relative all'app
    'region_filter_operator' => '=',
    'region_filter_id' => '{int: id regione}', // id regione da tabella loc_regione
    'google_key' => "{chiave api google (necessaria abilitazione maps e routing)}", // chiave api google
    'geoserver_map_url' => '{path layer tile geoserver}',
    'geoserver_services_url' => '{url wms e wfs geoserver}',
    'cesium_ion_token' => '{token cesium}',
    'cesium_resolution_scale' => 1,
    'geoserver_layers' => [ // array di layer, (vedere readme)
    ],
    'exclude_geoserver_from_map' => true,
    'secret-key' => '{chiave segreta token}', // chiave per generazione token
    'iss' => '{url}', // parametri da utilizzare nel jwt
    'aud' => '{url}', // parametri da utilizzare nel jwt
    'tid' => '{url}', // parametri da utilizzare nel jwt
    'sync_credentials' => [
        'user' => '{user mgo services}', // credenziali per sincronizzazione con MGO
        'pwd' => '{password mgo services}' // credenziali per sincronizzazione con MGO
    ],
    'mgo_api_base_url' => '{mgo api url}',
    'mgo_api_cookie_domain' => '{mgo api cookie domain}',
    'mgo_api_username' => '{mgo api username}',
    'mgo_api_password' => '{mgo api password}',
    'encryption' => [
        'key' => '{token encryption key}' // chiave cifratura
    ],
    'elicopters' => [
        'host' => '{host dati elicotteri}', // host servizi per dati elicotteri
        'api_key' => '{chiave api elicotteri}' // chiave api servizi elicotteri
    ],
    'segnalazioni_da_lavorare' => '{app|all}', // app || all
    'sync_everbridge' => false,
    'everbridge' => [
        'EVERBRIDGE_USER' => '{user everbridge}',
        'EVERBRIDGE_PASSWORD' => '{password everbridge}',
        'EVERBRIDGE_ORGANIZATION_ID' => '{organization id everbridge}',
        'EVERBRIDGE_RECORD_TYPE_ID' => '{record type everbridge}',
        'const_configuration' => [
            'paths' => [
                'email' => [
                    'allerta' => [],
                    'messaggistica' => []
                ],
                'sms' => [
                    'allerta' => [],
                    'messaggistica' => []
                ],
                'fax' => [
                    'allerta' => [],
                    'messaggistica' => []
                ]
            ],
            'recordTypeId' => '{record type everbridge}',
            'organizationId' => '{organization id everbridge}'
        ]
    ],
    'ADDRESSES_FILE_NAME' => '{nome file indirizzi: ES. addresses.csv}',
    'base_mas_callback' => 'http://websorapi:80/v1',
    'cap_test_username' => '{test user}',
    'cap_test_password' => '{password}',
    'cap_password_secret_key' => '{chiave segreta}',
    'cap_parsing_seconds' => 60 * 5,
    'helicopters_minutes' => 15,
    'helicopters_load_list_seconds_interval' => 60,
    'cap' => [
        'base_feed_url' => '{url feed cap}',
        'code' => 'CAP-IT-VF:0.1',
        'sender' => '{sender}',
        'senderName' => '{nome sender}',
        'contact' => '',
        'source' => '',
        'scope' => 'Restricted',
        'pagination' => 100
    ],

    'mas_version' => '{1|2}', //2,


    // v1 specific
    'mas_host' => '{host}',
    'mas_username' => '{user}',
    'mas_password' => '{password}',
    'mas_token' => '{token}',

    // v2 specific
    'mas_v2_host' => '{host}',
    'mas_host_public' => '{url pubblico}',
    'mas_frontend_url' => '{url frontend}',
    'mas_consumer_role' => '{ruolo del consumer}',
    'mas_websor_user_role' => '{utente proveniente da websor}',
    'mapping_tipo_messaggio' => [
        'allerta' => 'ALLERTA METEO',
        'messaggio' => 'MESSAGGIO'
    ]
];
