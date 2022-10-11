<?php
return [
    'websorType' => 'regionale', // Tipo istanza websor "regionale", "comunale", "sovracomunale", "provinciale"
    'view_sync_log' => true,
    'websorCitiesIstat' => '{codici istat comuni}', // Codici istat comuni per istanze comunali
    'showCartography' => true,
    'proxyUrl' => '',
    'laziocreaserver' => false,
    'adminEmail' => 'sara.albieri@regione.emilia-romagna.it', // email amministratore
    'approvazioneElicotteroEmail' => '{email approvazioni elicottero}', // indirizzo ricevente richieste di approvazione elicotteri
    'feedbackApprovazioneElicotteroMail' => '{email feedback approvazioni elicottero}', // email ricevente feedback delle approvazioni degli elicotteri
    'coauMail' => '{indirizzo email Coau}', // indirizzo email del coau
    'coauMailCC' => '{indirizzo email CC Coau}', // indirizzo email in CC del coau
    'supportEmail' => '{indirizzo email supporto}', // indirizzo email del supporto
    'user.passwordResetTokenExpire' => '86400', //es. 86400
    'audittrail.table' => 'tbl_audit_trail',
    'lat' => '41.8897701', // latitudine di base delle mappe
    'lng' => '12.476135', // longitudine di base delle mappe
    'gmap_ne_latlng' => [
        'lat' => '41.8897701', // lat bbox nord est
        'lng' => '12.476135', // lon bbox nord est
    ],
    'gmap_sw_latlng' => [
        'lat' => '43.63480', // lat bbox sud ovest
        'lng' => '9.16477', // lon bbox sud ovest
    ],
    'zoom' => '12', // livello base zoom
    'APP_NAME' => 'WebSor', // nome app mobile
    'REGION_NAME' => 'Emilia-Romagna', // aggiunto per messaggio mail
    'MAIL_APP_SENDER' => '{Firma mail per app}', // Firma nel footer delle email relative all'app
    'region_filter_operator' => '=',
    'region_filter_id' => '8', // id regione da tabella loc_regione
    'google_key' => "AIzaSyBpyKSKkys1XaWC-ED3Qrj-39C7c4huZ04", // chiave api google
    'openstreetmap_key' => 'cQuuEyLiZ2UQRMAxmIj9RU22gvoGLMomyxvPz-6fWmU', //chiave api OAuth2 di Openstreetmap
    'mapquest_key' => '0Mev0rWdzQtXCeH1bj86jnKeiopL8rTA',
    'geoserver_map_url' => 'http://vm111lnx.ente.regione.emr.it:8080/geoserver',
    'geoserver_services_url' => 'http://vm111lnx.ente.regione.emr.it:8080/geoserver/postgis/',
    'cesium_ion_token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiI3NGJmMDU5Yi04YTVlLTRkNjQtOGE5MS02OWJmYjQwODA3NjUiLCJpZCI6MTA4MjA4LCJpYXQiOjE2NjMzMTA1MTl9.1iflAASDgRcp3F04NDteiVMooI-jGY5zh4IavicfkMg', //token di Cesium (SARA)
    'cesium_resolution_scale' => 1,
    'geoserver_layers' => [
        [
            'name' => 'APC - RER',
            'type' => 'group', // tipo di layer
            'activable' => true,
            'layers' => [ // i layer contenuti nel gruppo
                [
                    'name' => 'Ortofoto CGR 2018 RGB (WMS)',
                    'type' => 'wms', // possibile wms|wfs|elicottero|image
                    'visible' => true,// impostarne solo 1 visibile
                    'identifier' => "Cgr2018_RGB",
                    'projection' => 'EPSG:4326',
                    'url' => 'http://servizigis.regione.emilia-romagna.it/wms/CGR2018_rgb?request=GetCapabilities&service=WMS',
                    'searchable' => true,
                    'legendable' => true,
                    'refreshable' => false,
                    'defaultSearchParams' => [
                    ]
                ],
                [
                    'name' => 'aipo_rilievi_topografici',
                    'type' => 'wms',
                    'visible' => false,// impostarne solo 1 visibile
                    'identifier' => "",
                    'projection' => 'EPSG:4326',
                    'url' => 'http://geomap.reteunitaria.piemonte.it/ws/siti/aipo-01/sitiwms/wms_aipo_rilievi_topografici?service=WMS&request=getCapabilities',
                    'searchable' => true,
                    'legendable' => true,
                    'refreshable' => false,
                    'defaultSearchParams' => [
                    ]
                ],
                [
                    'name' => 'Prova - ESEMPIO',
                    'type' => 'wms', // possibile wms|wfs|elicottero|image
                    'visible' => false,
                    'identifier' => "Sfumo",
                    'url' => 'http://servizigis.regione.emilia-romagna.it/wms/sfumo_altimetrico5_bosco?service=WMS&request=getCapabilities',
                    'searchable' => true, // ricercabile con la ricerca per poligono, cerchio e punto
                    'legendable' => true, // se impostato a true mostra la legenda quando il layer è attivo
                    'refreshable' => false, // se impostato a true il layer viene ricaricato ogni 30 secondi (se attivo)
                    'projection' => 'EPSG:23033', // importante se proiezioni diverse
                    'geom_field' => 'the_geom', // da impostare se il campo che identifica la geometria nel layer è diverso da geom (case sensitive)
                    'defaultSearchParams' => [ // parametri di ricerca di default su query CQL
                        ['stato', '<>', '\'Chiuso\''] // {nome campo}, {operatore}, {valore}
                    ]
                ]
            ]
        ],
        [
            'name' => 'OSM',
            'type' => 'tile',
            'identifier' => "osm",
            'icon' => 'osm', // valori disponibili: osm, realvista
            'visible'=> true, // impostarne solo 1 visibile
            'source_type' => 'OlSourceOsm',// valori disponibili OlSourceOsm, TileWMS
            'source_config' => [ // array che viene passato a openlayer
                'attributions'=> ["OpenStreetMap"],
                'url' => "http://tile.openstreetmap.org/{z}/{x}/{y}.png"
            ]
        ],
        [
            'name' => 'Google',
            'type' => 'tile',
            'identifier' => "google",
            'icon' => 'realvista',
            'visible'=>false,// impostarne solo 1 visibile
            'source_type' => 'OlSourceOsm',
            'source_config' => [
                'attributions'=> ["© Google",'<a href="http://developers.google.com/maps/terms">Terms of Use.</a>'],
                'url' => "https://www.google.it/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}"
            ]
        ],
        [
            'name' => 'Google Hybrid',
            'type' => 'tile',
            'identifier' => "google",
            'icon' => 'realvista',
            'visible'=>false,// impostarne solo 1 visibile
            'source_type' => 'OlSourceOsm',
            'source_config' => [
                'attributions'=> ["© Google",'<a href="http://developers.google.com/maps/terms">Terms of Use.</a>'],
                'url' => "https://www.google.it/maps/vt?lyrs=y@189&gl=cn&x={x}&y={y}&z={z}"
            ]
        ],
        [
            'name' => 'Google Terrain',
            'type' => 'tile',
            'identifier' => "google",
            'icon' => 'realvista',
            'visible'=>false,
            'source_type' => 'OlSourceOsm',
            'source_config' => [
                'attributions'=> ["© Google",'<a href="http://developers.google.com/maps/terms">Terms of Use.</a>'],
                'url' => "https://www.google.it/maps/vt?lyrs=p@189&gl=cn&x={x}&y={y}&z={z}"
            ]
        ],

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

    /*'mas_version' => '{1|2}', //2,

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
    ],
    */
];
