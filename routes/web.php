<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AppareilController;
use App\Http\Controllers\Admin\AppartementMaterielController;
use App\Http\Controllers\Admin\AvisPassageTextController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ColorTechnicienController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\FileStorageController;
use App\Http\Controllers\Admin\MaterielController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\StatusTechnicienController;
use App\Http\Controllers\Admin\SyncController;
use App\Http\Controllers\Admin\TechnicienController;
use App\Http\Controllers\Admin\TemplateDocumentController;
use App\Http\Controllers\Admin\TypeErreurController;
use App\Http\Controllers\Admin\TypeEventController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AppartementsController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CartographyController;
use App\Http\Controllers\CentraleController;
use App\Http\Controllers\ConvertisseurGoogleAgendaController;

use App\Http\Controllers\FacturationsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListeSDCController;
use App\Http\Controllers\MailContentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\XmlController;


use App\Http\Controllers\immeubles\ImmeublesController;
use App\Http\Controllers\immeubles\DetailsController;
use App\Http\Controllers\immeubles\DonneesGeneraleController;
use App\Http\Controllers\immeubles\DocumentsController;
use App\Http\Controllers\immeubles\FacturesController;
use App\Http\Controllers\immeubles\InterventionsController;


use App\Http\Controllers\Saisie\SaisieController;

use App\Http\Controllers\Decompte\DecompteController;
use App\Http\Controllers\Decompte\WordDocumentController;
use App\Http\Controllers\Decompte\GestionErrorController;
use App\Http\Controllers\Saisie\GestionStatutController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    //    return view('dashboard');
    return redirect()->route('immeubles.index');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('admin/property/{Codecli_id}/appartement/{appartement_id}/{type}/{numCal}', [PropertyController::class, 'showReleve'])->name('admin.property.showReleve');
Route::get('admin/client/{client}/modifier', [ClientController::class, 'edit'])->name('admin.client.modifier');
Route::put('admin/client/', [ClientController::class, 'update'])->name('admin.client.update');

//->middleware(['auth', 'verified', 'role:admin'])
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [AdminController::class, 'migrationRelChaufToReleve'])->name('index');
    Route::get('/client/geocodeClient', [ClientController::class, 'geocodeClient'])->name('client.geocodeClient');
    
    Route::resource('typeErreur', TypeErreurController::class)->except(['show']);
    Route::resource('contact', ContactController::class)->except(['show']);
    Route::resource('user', UserController::class)->except(['show']);
    Route::resource('file_storage', FileStorageController::class)->except(['show']);
    Route::get('/convertisseurAgenda', [ConvertisseurGoogleAgendaController::class, 'convertisseurAgenda'])->name('convertisseurAgenda');

// Techniciens
    Route::resource('technicien', technicienController::class)->except(['show']);
    Route::resource('statusTechnicien', StatusTechnicienController::class)->except(['show']);
    Route::resource('couleurTechnicien', ColorTechnicienController::class)->except(['show']);
    route::get('/techniciensAjax', [TechnicienController::class, 'techniciensAjax'])->name('techniciensAjax');
    Route::get('/createAbsenceTechnicien/{id}', [TechnicienController::class, 'createAbsenceTechnicien'])->name('createAbsenceTechnicien');
    Route::post('/storeAbsenceTechnicien', [TechnicienController::class, 'storeAbsenceTechnicien'])->name('storeAbsenceTechnicien');

//Events
    Route::resource('event', EventController::class)->except(['show']);
    Route::post('/event/createEvent', [EventController::class, 'create'])->name('createEvent');
    Route::get('/eventReleveGeneraux', [EventController::class, 'eventReleveGeneraux'])->name('eventReleveGeneraux');
    Route::get('/eventSecondPassage', [EventController::class, 'eventSecondPassage'])->name('eventSecondPassage');
    Route::get('/eventTroisiemePassage', [EventController::class, 'eventTroisiemePassage'])->name('eventTroisiemePassage');
    Route::resource('typeEvent', TypeEventController::class)->except(['show']);
    Route::get('/event/appartementsAjax/{id}', [EventController::class, 'appartementsAjax'])->name('appartementsAjax');
    Route::post('/ordreEvent', [EventController::class, 'ordreEvent'])->name('ordreEvent');
    Route::get('/ShowEventImmeublesAjax', [EventController::class, 'ShowEventImmeublesAjax'])->name('ShowEventImmeublesAjax');

// avis de passage text
    route::resource('avisPassageText', AvisPassageTextController::class)->except(['show']);
    route::post('/avisPassageText/{id}', [AvisPassageTextController::class, 'update'])->name('update');


// appareil matériels
    Route::post('/appareil/{id}', [ AppareilController::class, 'updateAppareil'])->name('appareil_update');
    Route::resource('materiel', MaterielController::class)->except(['show']);
    Route::resource('appareil', AppareilController::class)->except(['show']);


    Route::get('/regen', [AdminController::class, 'quickRegen'])->name('quickregen');

    // group sync
    Route::prefix('sync')->name('sync.')->group(function () {
        Route::get('/', [SyncController::class, 'index'])->name('index');
        Route::get('/contact', [SyncController::class, 'popContact'])->name('contact');
        Route::get('/client', [SyncController::class, 'popClient'])->name('client');
        Route::get('/appartement', [SyncController::class, 'popAppartement'])->name('appartement');
        Route::get('/gerantimm', [SyncController::class, 'popGerantImm'])->name('gerantImm');
        Route::get('/relapp', [SyncController::class, 'popRelApp'])->name('relapp');
        Route::get('/codepostelb', [SyncController::class, 'popCodePostelb'])->name('codepostelb');
        Route::get('/relclients_codepostelbs', [SyncController::class, 'popRelClientsPosteCode'])->name('relclients_codepostelbs');
        Route::get('/cli_chauff', [SyncController::class, 'popCliChauff'])->name('cli_chauff');
        Route::get('/cli_eau', [SyncController::class, 'popCliEau'])->name('cli_eau');
        Route::get('/relradchf', [SyncController::class, 'popRelradChf'])->name('relradchf');
        Route::get('/relradeau', [SyncController::class, 'popRelradEau'])->name('relradeau');
        Route::get('/relchaufapp', [SyncController::class, 'popRelChaufApp'])->name('relchaufapp');
        Route::get('/releauapp', [SyncController::class, 'popRelEauApp'])->name('releauapp');
        Route::get('/relchauf', [SyncController::class, 'popRelChauf'])->name('relchauf');
        Route::get('/releauc', [SyncController::class, 'popRelEauC'])->name('releauc');
        Route::get('/releauf', [SyncController::class, 'popRelEauF'])->name('releauf');
    });

    //    Route::get('/sync', [SyncController::class, 'PopContact'])->name('sync');
});


Route::prefix('documents')->name('documents.')->middleware(['auth', 'verified'])->group(function () {

    Route::post('/BonDeRouteAjax', [TemplateDocumentController::class, 'BonDeRouteAjax'])->name('BonDeRouteAjax');
    Route::post('/printBonDeRouteAjax', [TemplateDocumentController::class, 'printBonDeRouteAjax'])->name('printBonDeRouteAjax');

    Route::get('/listeDocument/{type}', [TemplateDocumentController::class, 'listeDocument'])->name('listeDocument');
    Route::get('/searchDocument/{type}', [TemplateDocumentController::class, 'searchDocument'])->name('searchDocument');

    Route::get('/listeSDC', [ListeSDCController::class, 'index'])->name('listeSDC');
    Route::get('/showListeSDC/{id}', [ListeSDCController::class, 'showListeSDC'])->name('showListeSDC');
    Route::get('/printListeSDC/{id}', [ListeSDCController::class, 'printListeSDC'])->name('printListeSDC');
    Route::get('/downloadListeSDC/{id}', [ListeSDCController::class, 'downloadListeSDC'])->name('downloadListeSDC');
    Route::post('listeSDC/store', [ListeSDCController::class, 'store'])->name('listeSDC.store');

    Route::get('/showDocument/{id}', [TemplateDocumentController::class, 'showDocument'])->name('showDocument');
    Route::get('/editDocument/{id}', [TemplateDocumentController::class, 'editDocument'])->name('editDocument');
    Route::post('/updateDocument', [TemplateDocumentController::class, 'updateDocument'])->name('updateDocument');
    Route::get('/deleteDocument/{id}', [TemplateDocumentController::class, 'deleteDocument'])->name('deleteDocument');

    Route::get('/showFeuilleFrais', [TemplateDocumentController::class, 'showFeuilleFrais'])->name('showFeuilleFrais');

    //Route::get('/sendMail', [SendMailController::class, 'index'])->name('sendMail');
    Route::post('/sendMail', [SendMailController::class, 'send'])->name('sendMail');

    Route::get('/printBonDeRoute/{id}', [TemplateDocumentController::class, 'printBonDeRoute'])->name('printBonDeRoute');
    Route::get('/downloadPdfBonDeRoute/{id}', [TemplateDocumentController::class, 'downloadPdfBonDeRoute'])->name('downloadPdfBonDeRoute');
    Route::get('/downloadPdfAvisDePassage/{id}', [TemplateDocumentController::class, 'downloadPdfAvisDePassage'])->name('downloadPdfAvisDePassage');
    Route::get('/downloadPdfFormCreateApps/{id}', [TemplateDocumentController::class, 'downloadPdfFormCreateApps'])->name('downloadPdfFormCreateApps');
    Route::get('/downloadCsvFormCreateApps/{id}', [TemplateDocumentController::class, 'downloadCsvFormCreateApps'])->name('downloadCsvFormCreateApps');
    Route::get('/downloadExcelFormCreateApps/{id}', [TemplateDocumentController::class, 'downloadExcelFormCreateApps'])->name('downloadExcelFormCreateApps');
    Route::get('/printAvisDePassage/{id}', [TemplateDocumentController::class, 'printAvisDePassage'])->name('printAvisDePassage');


    Route::get('/showRapport/{id}',  [TemplateDocumentController::class, 'showRapport'])->name('showRapport');
    Route::post('/createRapport', [TemplateDocumentController::class, 'createRapport'])->name('createRapport');
    Route::get('/editRapport/{id}', [TemplateDocumentController::class, 'editRapport'])->name('editRapport');
    Route::get('/deleteRapport/{id}/{created_at}', [TemplateDocumentController::class, 'deleteRapport'])->name('deleteRapport');
    Route::get('/import-clients', [TemplateDocumentController::class, 'showImportForm'])->name('clients.import.form');
    Route::post('/import-clients', [TemplateDocumentController::class, 'import'])->name('clients.import');

    Route::get('/showChauffage', [TemplateDocumentController::class, 'showChauffage'])->name('showChauffage');

});

Route::prefix('centrales')->name('centrales.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [CentraleController::class, 'index'])->name('index');
    Route::get('/liste/{id}', [CentraleController::class, 'centrale'])->name('centrale');
    Route::get('/detail/{id}', [CentraleController::class, 'detail'])->name('detail');
});

Route::get('/test/generateXmlFile', [XmlController::class, 'generateXmlFile'])->name('generateXmlFile');
Route::post('/test/parserXmlFile', [XmlController::class, 'parserXmlFile'])->name('parserXmlFile');
Route::get('/test/testParser', [XmlController::class, 'testerParser'])->name('testParser');


Route::prefix('immeubles')->name('immeubles.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [ImmeublesController::class, 'index'])->name('index');
    Route::post('/donneeGeneraleUpdate/{codecli}/{type}', [DonneesGeneraleController::class, 'donneeGeneraleUpdate'])->name('donneeGeneraleUpdate');
    Route::post('/provisionUpdate/{codecli}', [DonneesGeneraleController::class, 'provisionUpdate'])->name('provisionUpdate');
    Route::match(['get', 'post'], '/infoAppartUpdate/{codecli}', [DonneesGeneraleController::class, 'infoAppartUpdate'])->name('infoAppartUpdate');
    Route::post('/infoAppartUpdate/uploadCsv/{codecli}', [DonneesGeneraleController::class, 'infoAppartUpdateUploadCsv'])->name('infoAppartUpdate.uploadCsv');
    // Routes pour les différentes sections
    Route::get('/{id}/appartements', [DetailsController::class, 'getAppartements'])->name('appartements');
    
    Route::prefix('{id}/details')->group(function () {
        Route::get('/definition', [DetailsController::class, 'getDetails'])->name('details');
        Route::get('/graphiques', [DetailsController::class, 'getGraphiques'])->name('graphiques');
        Route::get('/chauffage', [DetailsController::class, 'getChauffage'])->name('chauffage');
        Route::get('/eau', [DetailsController::class, 'getEau'])->name('eau');
        Route::get('/gaz', [DetailsController::class, 'getGaz'])->name('gaz');
        Route::get('/electricite', [DetailsController::class, 'getElectricite'])->name('electricite');
        Route::get('/provision', [DetailsController::class, 'getProvision'])->name('provision');
        Route::get('/infoAppart', [DetailsController::class, 'getInfoAppart'])->name('infoAppart');
    });

    Route::get('/{id}/documents', [DocumentsController::class, 'index'])->name('documents');
    Route::get('/{id}/factures', [FacturesController::class, 'index'])->name('factures');
    Route::get('/{id}/interventions', [InterventionsController::class, 'index'])->name('interventions');

    Route::prefix('/{id}/saisie')->group(function () {
        Route::get('/chauffage', [SaisieController::class, 'index'])->name('saisie');
        Route::get('/eau', [SaisieController::class, 'saisieEau'])->name('saisieEau');
        Route::get('/gaz', [SaisieController::class, 'saisieGaz'])->name('saisieGaz');
        Route::get('/elec', [SaisieController::class, 'saisieElec'])->name('saisieElec');
        Route::post('/getSaisies', [SaisieController::class, 'getSaisies'])->name('getSaisies');
        Route::post('/getParametres', [SaisieController::class, 'getParametres'])->name('getParametres');
        Route::post('/getDateReleve', [SaisieController::class, 'getDateReleve'])->name('getDateReleve');
        Route::post('/removeDateReleve', [SaisieController::class, 'removeDateReleve'])->name('removeDateReleve');

        Route::prefix('/statut')->group(function () {
            Route::post('/nouveau', [GestionStatutController::class, 'nouveauStatut'])->name('nouveauStatut');
            Route::post('/remplace', [GestionStatutController::class, 'remplaceStatut'])->name('remplaceStatut');
            Route::post('/refix', [GestionStatutController::class, 'refixStatut'])->name('refixStatut');
            Route::post('/supprime', [GestionStatutController::class, 'supprimeStatut'])->name('supprimeStatut');
        });
    });
    
    Route::prefix('/{id}/decompte')->name('decompte')->group(function(){
        Route::get('/', [DecompteController::class, 'index'])->name('.index');
        Route::get('/preparation', [DecompteController::class, 'preparation'])->name('.preparation');
        Route::get('/cloture', [DecompteController::class, 'cloture'])->name('.cloture');
        Route::get('/editions', [DecompteController::class, 'editions'])->name('.editions');
        Route::post('/preparation/store', [DecompteController::class, 'storePreparation'])->name('.storePreparation');
        Route::post('/cloture/store', [DecompteController::class, 'storeCloture'])->name('.storeCloture');
        Route::post('/editions/store', [DecompteController::class, 'storeEditions'])->name('.storeEditions');
        Route::get('/listeErreurs', [GestionErrorController::class, 'index'])->name('.listeErreurs');
        Route::post('listeDecompte', [DecompteController::class, 'listeDecompte'])->name('.listeDecompte');

        
        Route::prefix('word')->group(function () {
            Route::get('/upload', [WordDocumentController::class, 'upload'])->name('word.upload');
            Route::post('/process', [WordDocumentController::class, 'process'])->name('word.process');
            Route::post('/update', [WordDocumentController::class, 'update'])->name('word.update');
            Route::get('/view/{file}', [WordDocumentController::class, 'view'])->name('word.view');
            Route::post('/convert', [WordDocumentController::class, 'convertToPdf'])->name('word.convert');
        });
    });

    // Routes existantes pour les appartements
    Route::get('/{Codecli_id}/appartement/{appartement_id}', [ImmeublesController::class, 'showAppartement'])->name('showAppartement');
    Route::post('/{Codecli_id}/appartement/{appartement_id}', [ImmeublesController::class, 'storeNote'])->name('storeNote');
    Route::post('/{Codecli_id}/appartement/absent/{appartement_id}', [ImmeublesController::class, 'storeAbsent'])->name('storeAbsent');
    Route::get('/{Codecli_id}/appartement/{appartement_id}/{type}/{numCal}', [ImmeublesController::class, 'showReleve'])->name('showReleve');

    Route::resource('file_storage', ImmeublesController::class)->except(['show']);

    Route::get('/{Codecli}/appartement/{appartement_id}/edit', [AppartementsController::class, 'edit'])->name('PropertyEdit');
    Route::post('/{Codecli}/appartement/{appartement_id}/update', [AppartementsController::class, 'update'])->name('PropertyUpdate');
    Route::post('/{Codecli}/appartement/{appartement_id}/DetailUpdate', [AppartementsController::class, 'DetailUpdate'])->name('DetailUpdate');
    Route::post('/{Codecli_id}/appartement/{appartement_id}/AddIndex', [AppareilController::class, 'addIndex'])->name('AddIndex');


    Route::prefix('ajaxRequest')->group(function () {
        Route::get('/getAppartements/{codecli}', [App\Http\Controllers\immeubles\AppartementsController::class, 'getAppartements'])->name('immeubles.details.getAppartements');
        Route::get('/getDetails/{codecli}', [App\Http\Controllers\immeubles\DetailsController::class, 'getDetails'])->name('immeubles.details.getDetails');
        Route::prefix('/details')->group(function () {
            Route::get('/getDefinition/{codecli}', [App\Http\Controllers\immeubles\DetailsController::class, 'getDefinition'])->name('immeubles.details.getDefinition');
            Route::get('/getChauffage/{codecli}', [App\Http\Controllers\immeubles\DetailsController::class, 'getChauffage'])->name('immeubles.details.getChauffage');
            Route::get('/getEau/{codecli}', [App\Http\Controllers\immeubles\DetailsController::class, 'getEau'])->name('immeubles.details.getEau');
            Route::get('/getGaz/{codecli}', [App\Http\Controllers\immeubles\DetailsController::class, 'getGaz'])->name('immeubles.details.getGaz');
            Route::get('/getElectricite/{codecli}', [App\Http\Controllers\immeubles\DetailsController::class, 'getElectricite'])->name('immeubles.details.getElectricite');
            Route::get('/getProvision/{codecli}', [App\Http\Controllers\immeubles\DetailsController::class, 'getProvision'])->name('immeubles.details.getProvision');
            Route::get('/getInfoAppart/{codecli}', [App\Http\Controllers\immeubles\DetailsController::class, 'getInfoAppart'])->name('immeubles.details.getInfoAppart');
        });
    });

});
Route::get('/property/{Codecli}/appartement/{appartement_id}/edit', [AppartementsController::class, 'edit'])->name('PropertyEdit');
Route::post('/property/{Codecli}/appartement/{appartement_id}', [AppartementsController::class, 'update'])->name('PropertyUpdate');
Route::post('/property/{Codecli}/appartement/{appartement_id}/Detail', [AppartementsController::class, 'store'])->name('PropertyStore');
Route::post('immeubles/store', [AppartementsController::class, 'storeAppartement'])->name('storeAppartement');


Route::get('/searchByNameOrCodecli', [ImmeublesController::class, 'searchClientByNameOrCodecli'])->name('searchClientByNameOrCodecli');
Route::get('/searchByCPOrLocalite', [ImmeublesController::class, 'searchClientByCPOrLocalite'])->name('searchClientByCPOrLocalite');
Route::get('/searchByStreet', [ImmeublesController::class, 'searchClientByStreet'])->name('searchClientByStreet');
Route::get('/searchByTypeInter', [EventController::class, 'searchEventByTypInter'])->name('searchEventByTypInter');
Route::get('/searchEventByTechniciens', [TechnicienController::class, 'searchEventByTechniciens'])->name('searchEventByTechniciens');
route::get('/searchByMateriel', [MaterielController::class, 'searchByMateriel'])->name('searchByMateriel');

Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
Route::get('/cartography', [CartographyController::class, 'index'])->name('cartography.index');
Route::get('/cartography/Technicien', [CartographyController::class, 'cartographyTechnicien'])->name('cartography.cartographyTechnicien');
Route::get('/cartography/getEventsCartography', [CartographyController::class, 'getEventsCartography'])->name('cartography.getEventsCartography');
Route::get('/cartography/getEventTimeline', [CartographyController::class, 'getEventTimeline'])->name('cartography.getEventTimeline');
Route::get('event/eventAjax', [EventController::class, 'eventAjax'])->name('event.eventAjax');
Route::get('event/eventAjaxNoDate', [EventController::class, 'eventAjaxNoDate'])->name('event.eventAjaxNoDate');
Route::post('event/update_eventAjax', [EventController::class, 'updateEventAjax'])->name('update_eventAjax');
Route::post('event/updateTime_eventAjax', [EventController::class, 'updateTimeEventAjax'])->name('updateTime_eventAjax');
Route::post('event/updateAllDay_eventAjax', [EventController::class, 'UpdateAllDay'])->name('updateAllDay_eventAjax');


Route::prefix('ajax')->name('ajax')->group(function () {
    Route::post('/getAppartements', [ImmeublesController::class, 'getAppartements'])->name('.getAppartements');
    Route::get('/form-part/{type}', [AjaxController::class, 'getFormMaterielType']);
    Route::get('/form-part-genre/{genre}', [AjaxController::class, 'getFormMaterielGenre']);
    Route::get('/form-part-commu/{commu}', [AjaxController::class, 'getFormMaterielCommu']);
    Route::get('/form-part-model', [AjaxController::class, 'getFormModel']);
    Route::get('/form-part-commu-sontex', [AjaxController::class, 'getFormCommuSontex']);
    Route::get('/form-part-commu-sontex2', [AjaxController::class, 'getFormCommuSontex2']);
    Route::get('/form-part-dim', [AjaxController::class, 'getFormDimension']);
    Route::get('/user', function () {
        return Auth::user();
    });
    //Route::post('/postTechniciensCheckedAjax', [TechnicienController::class, 'postTechniciensCheckedAjax'])->name('.postTechniciensCheckedAjax');
    Route::post('/eventTimelineAjax', [EventController::class, 'eventTimelineAjax'])->name('.eventTimelineAjax');
   

    // Route::get('/getDetail/{id}', [\App\Http\Controllers\AjaxImmeubleController::class, 'getDetail'])->name('getDetail');

});

Route::prefix('appartementMateriel')->name('appartementMateriel')->group(function(){
    Route::get('/', [AppartementMaterielController::class, 'index'])->name('.index');
    Route::get('/create', [AppartementMaterielController::class, 'create'])->name('.create');
    Route::post('/store', [AppartementMaterielController::class, 'store'])->name('.store');
    Route::get('/edit/{id}', [AppartementMaterielController::class, 'edit'])->name('.edit');
    Route::post('/update/{id}', [AppartementMaterielController::class, 'update'])->name('.update');
    Route::get('/delete/{id}', [AppartementMaterielController::class, 'destroy'])->name('.destroy');

});



Route::post('/getTypeErreur', [AppareilController::class, 'appareilTypeErreur'])->name('.getTypeErreur');

Route::post('/property/store', [PropertyController::class, 'store'])->name('store');


Route::get('facturation/tri', [FacturationsController::class, 'index'])->name('facturation.index');
Route::get('facturation/listeFactures', [FacturationsController::class, 'listeFacture'])->name('facturation.listeFactures');
Route::get('facturation/detailFacture/{id}', [FacturationsController::class, 'detailFacture'])->name('facturation.detailFacture');
Route::get('facturation/generateFacture', [FacturationsController::class, 'generateFacture'])->name('facturation.generateFacture');
Route::post('facturation/resultTriAjax', [FacturationsController::class, 'resultTriAjax'])->name('resultTriAjax');

Route::resource('mailContents', MailContentController::class)->except('show');

Route::get('/test', [TemplateDocumentController::class, 'test'])->name('test');

// Routes pour les relevés
Route::prefix('releves')->group(function () {
    Route::get('/{codeCli}', [App\Http\Controllers\ReleveController::class, 'index'])->name('releves.index');
    Route::get('/{type}/{codeCli}/{refAppTR}', [App\Http\Controllers\ReleveController::class, 'show'])
        ->name('releves.show')
        ->where('type', 'chauffage|eau|gaz|elec');

    
});

Route::get('/parametres', [App\Http\Controllers\ReleveController::class, 'getParam'])->name('releves.getParam');
Route::get('/saisie', [App\Http\Controllers\ReleveController::class, 'getSaisie'])->name('releves.getSaisie');

// Routes pour les détails des immeubles
require __DIR__.'/auth.php';

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

