<?php

/*
|--------------------------------------------------------------------------
| Web routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth routes
Auth::routes(['verify' => true]);
Route::post('login/tfa/validate', 'Auth\LoginController@validateTfaCode')->name('login.tfa.validate');
Route::post('login/tfa/resend', 'Auth\LoginController@resendTfaCode')->name('login.tfa.resend');
Route::get('tg-auth/{hash}', 'TGAuthController@index')->name('tg.auth');

// Install routes
Route::prefix('install')->group(function () {
    Route::middleware('install')->group(function () {
        Route::get('/', 'InstallController@index')->name('install');
        Route::get('/requirements', 'InstallController@requirements')->name('install.requirements');
        Route::get('/permissions', 'InstallController@permissions')->name('install.permissions');
        Route::get('/database', 'InstallController@database')->name('install.database');
        Route::get('/account', 'InstallController@account')->name('install.account');

        Route::post('/database', 'InstallController@storeConfig');
        Route::post('/account', 'InstallController@storeDatabase');
    });

    Route::get('/complete', 'InstallController@complete')->name('install.complete');
});

// Update routes
Route::prefix('update')->group(function () {
    Route::get('/', 'UpdateController@index')->name('update');
    Route::get('/overview', 'UpdateController@overview')->name('update.overview');
    Route::get('/complete', 'UpdateController@complete')->name('update.complete');

    Route::post('/overview', 'UpdateController@updateDatabase');
});

// Locale routes
Route::post('/locale', 'LocaleController@updateLocale')->name('locale');

// Home routes
Route::get('/', 'HomeController@index')->name('home');

// Contact routes
Route::get('/contact', 'ContactController@index')->name('contact');
Route::post('/contact', 'ContactController@send')->middleware('throttle:5,10');

// Page routes
Route::get('/pages/{id}', 'PageController@show')->name('pages.show');

// Dashboard routes
Route::get('/dashboard', 'DashboardController@index')->middleware('verified')->name('dashboard');

// Template routes
Route::prefix('templates')->middleware('verified')->group(function () {
    Route::get('/', 'TemplateController@index')->name('templates');

    Route::get('/article', 'TemplateController@article')->name('templates.article');
    Route::post('/article', 'TemplateController@processArticle');

    Route::get('/paragraph', 'TemplateController@paragraph')->name('templates.paragraph');
    Route::post('/paragraph', 'TemplateController@processParagraph');

    Route::get('/blog-post', 'TemplateController@blogPost')->name('templates.blog_post');
    Route::post('/blog-post', 'TemplateController@processBlogPost');

    Route::get('/blog-paragraph', 'TemplateController@blogParagraph')->name('templates.blog_paragraph');
    Route::post('/blog-paragraph', 'TemplateController@processBlogParagraph');

    Route::get('/blog-title', 'TemplateController@blogTitle')->name('templates.blog_title');
    Route::post('/blog-title', 'TemplateController@processBlogTitle');

    Route::get('/blog-section', 'TemplateController@blogSection')->name('templates.blog_section');
    Route::post('/blog-section', 'TemplateController@processBlogSection');

    Route::get('/blog-intro', 'TemplateController@blogIntro')->name('templates.blog_intro');
    Route::post('/blog-intro', 'TemplateController@processBlogIntro');

    Route::get('/blog-outro', 'TemplateController@blogOutro')->name('templates.blog_outro');
    Route::post('/blog-outro', 'TemplateController@processBlogOutro');

    Route::get('/blog-talking-points', 'TemplateController@blogTalkingPoints')->name('templates.blog_talking_points');
    Route::post('/blog-talking-points', 'TemplateController@processBlogTalkingPoints');

    Route::get('/blog-outline', 'TemplateController@blogOutline')->name('templates.blog_outline');
    Route::post('/blog-outline', 'TemplateController@processBlogOutline');

    Route::get('/content-rewrite', 'TemplateController@contentRewrite')->name('templates.content_rewrite');
    Route::post('/content-rewrite', 'TemplateController@processContentRewrite');

    Route::get('/content-summary', 'TemplateController@contentSummary')->name('templates.content_summary');
    Route::post('/content-summary', 'TemplateController@processContentSummary');

    Route::get('/headline', 'TemplateController@headline')->name('templates.headline');
    Route::post('/headline', 'TemplateController@processHeadline');

    Route::get('/subheadline', 'TemplateController@subheadline')->name('templates.subheadline');
    Route::post('/subheadline', 'TemplateController@processSubheadline');

    Route::get('/call-to-action', 'TemplateController@callToAction')->name('templates.call_to_action');
    Route::post('/call-to-action', 'TemplateController@processCallToAction');

    Route::get('/testimonial', 'TemplateController@testimonial')->name('templates.testimonial');
    Route::post('/testimonial', 'TemplateController@processTestimonial');

    Route::get('/meta-description', 'TemplateController@metaDescription')->name('templates.meta_description');
    Route::post('/meta-description', 'TemplateController@processMetaDescription');

    Route::get('/about-us', 'TemplateController@aboutUs')->name('templates.about_us');
    Route::post('/about-us', 'TemplateController@processAboutUs');

    Route::get('/advertisement', 'TemplateController@advertisement')->name('templates.advertisement');
    Route::post('/advertisement', 'TemplateController@processAdvertisement');

    Route::get('/newsletter', 'TemplateController@newsletter')->name('templates.newsletter');
    Route::post('/newsletter', 'TemplateController@processNewsletter');

    Route::get('/mission-statement', 'TemplateController@missionStatement')->name('templates.mission_statement');
    Route::post('/mission-statement', 'TemplateController@processMissionStatement');

    Route::get('/vision-statement', 'TemplateController@visionStatement')->name('templates.vision_statement');
    Route::post('/vision-statement', 'TemplateController@processVisionStatement');

    Route::get('/press-release', 'TemplateController@pressRelease')->name('templates.press_release');
    Route::post('/press-release', 'TemplateController@processPressRelease');

    Route::get('/value-proposition', 'TemplateController@valueProposition')->name('templates.value_proposition');
    Route::post('/value-proposition', 'TemplateController@processValueProposition');

    Route::get('/hashtags', 'TemplateController@hashtags')->name('templates.hashtags');
    Route::post('/hashtags', 'TemplateController@processHashtags');

    Route::get('/social-media-quote', 'TemplateController@socialMediaQuote')->name('templates.social_media_quote');
    Route::post('/social-media-quote', 'TemplateController@processSocialMediaQuote');

    Route::get('/social-media-bio', 'TemplateController@socialMediaBio')->name('templates.social_media_bio');
    Route::post('/social-media-bio', 'TemplateController@processSocialMediaBio');

    Route::get('/video-title', 'TemplateController@videoTitle')->name('templates.video_title');
    Route::post('/video-title', 'TemplateController@processVideoTitle');

    Route::get('/video-description', 'TemplateController@videoDescription')->name('templates.video_description');
    Route::post('/video-description', 'TemplateController@processVideoDescription');

    Route::get('/video-tags', 'TemplateController@videoTags')->name('templates.video_tags');
    Route::post('/video-tags', 'TemplateController@processVideoTags');

    Route::get('/freestyle', 'TemplateController@freestyle')->name('templates.freestyle');
    Route::post('/freestyle', 'TemplateController@processFreestyle');

    Route::get('/faq', 'TemplateController@faq')->name('templates.faq');
    Route::post('/faq', 'TemplateController@processFaq');

    Route::get('/how-it-works', 'TemplateController@howItWorks')->name('templates.how_it_works');
    Route::post('/how-it-works', 'TemplateController@processHowItWorks');

    Route::get('/meta-keywords', 'TemplateController@metaKeywords')->name('templates.meta_keywords');
    Route::post('/meta-keywords', 'TemplateController@processMetaKeywords');

    Route::get('/video-script', 'TemplateController@videoScript')->name('templates.video_script');
    Route::post('/video-script', 'TemplateController@processVideoScript');

    Route::get('/startup-names', 'TemplateController@startupNames')->name('templates.startup_names');
    Route::post('/startup-names', 'TemplateController@processStartupNames');

    Route::get('/startup-ideas', 'TemplateController@startupIdeas')->name('templates.startup_ideas');
    Route::post('/startup-ideas', 'TemplateController@processStartupIdeas');

    Route::get('/pain-agitate-solution', 'TemplateController@painAgitateSolution')->name('templates.pain_agitate_solution');
    Route::post('/pain-agitate-solution', 'TemplateController@processPainAgitateSolution');

    Route::get('/social-post', 'TemplateController@socialPost')->name('templates.social_post');
    Route::post('/social-post', 'TemplateController@processSocialPost');

    Route::get('/social-post-caption', 'TemplateController@socialPostCaption')->name('templates.social_post_caption');
    Route::post('/social-post-caption', 'TemplateController@processSocialPostCaption');

    Route::get('/product-sheet', 'TemplateController@productSheet')->name('templates.product_sheet');
    Route::post('/product-sheet', 'TemplateController@processProductSheet');

    Route::get('/welcome-email', 'TemplateController@welcomeEmail')->name('templates.welcome_email');
    Route::post('/welcome-email', 'TemplateController@processWelcomeEmail');

    Route::get('/push-notification', 'TemplateController@pushNotification')->name('templates.push_notification');
    Route::post('/push-notification', 'TemplateController@processPushNotification');

    Route::get('/blog-listicle', 'TemplateController@blogListicle')->name('templates.blog_listicle');
    Route::post('/blog-listicle', 'TemplateController@processBlogListicle');

    Route::get('/blog-tags', 'TemplateController@blogTags')->name('templates.blog_tags');
    Route::post('/blog-tags', 'TemplateController@processBlogTags');

    Route::get('/pros-cons', 'TemplateController@prosCons')->name('templates.pros_cons');
    Route::post('/pros-cons', 'TemplateController@processProsCons');

    Route::get('/content-grammar', 'TemplateController@contentGrammar')->name('templates.content_grammar');
    Route::post('/content-grammar', 'TemplateController@processContentGrammar');

    Route::get('/google-advertisement', 'TemplateController@googleAdvertisement')->name('templates.google_advertisement');
    Route::post('/google-advertisement', 'TemplateController@processGoogleAdvertisement');

    Route::get('/facebook-advertisement', 'TemplateController@facebookAdvertisement')->name('templates.facebook_advertisement');
    Route::post('/facebook-advertisement', 'TemplateController@processFacebookAdvertisement');

    Route::get('/job-description', 'TemplateController@jobDescription')->name('templates.job_description');
    Route::post('/job-description', 'TemplateController@processJobDescription');

    Route::get('/review', 'TemplateController@review')->name('templates.review');
    Route::post('/review', 'TemplateController@processReview');

    Route::get('/feature-section', 'TemplateController@featureSection')->name('templates.feature_section');
    Route::post('/feature-section', 'TemplateController@processFeatureSection');

    Route::get('/templates/new', 'TemplateController@create')->name('templates.new');
    Route::get('/templates/{id}/edit', 'TemplateController@edit')->name('templates.edit');
    Route::get('/templates/{id}', 'TemplateController@show')->name('templates.show');
    Route::post('/templates/new', 'TemplateController@store');
    Route::post('/templates/{id}', 'TemplateController@processShow');
    Route::post('/templates/{id}/edit', 'TemplateController@update');
    Route::post('/templates/{id}/destroy', 'TemplateController@destroy')->name('templates.destroy');
});

// Document routes
Route::get('/documents', 'DocumentController@index')->middleware('verified')->name('documents');
Route::get('/documents/export', 'DocumentController@export')->middleware('verified')->name('documents.export');
Route::get('/documents/new', 'DocumentController@create')->middleware('verified')->name('documents.new');
Route::get('/documents/{id}/edit', 'DocumentController@edit')->middleware('verified')->name('documents.edit');
Route::get('/documents/{id}', 'DocumentController@show')->middleware('verified')->name('documents.show');
Route::post('/documents/new', 'DocumentController@store')->middleware('verified');
Route::post('/documents/{id}/edit', 'DocumentController@update')->middleware('verified');
Route::post('/documents/{id}/destroy', 'DocumentController@destroy')->middleware('verified')->name('documents.destroy');

// Image routes DALL-E
Route::get('/images/dall-e', 'DALLEController@index')->middleware('verified')->name('images.dalle');
Route::get('/images/dall-e/new', 'DALLEController@create')->middleware('verified')->name('images.dalle.new');
Route::get('/images/dall-e/{id}/edit', 'DALLEController@edit')->middleware('verified')->name('images.dalle.edit');
Route::get('/images/dall-e/{id}', 'DALLEController@show')->middleware('verified')->name('images.dalle.show');
Route::post('/images/dall-e/new', 'DALLEController@store')->middleware('verified');
Route::post('/images/dall-e/{id}/edit', 'DALLEController@update')->middleware('verified');
Route::post('/images/dall-e/{id}/destroy', 'DALLEController@destroy')->middleware('verified')->name('images.dalle.destroy');

// Image routes Midjorney
Route::get('/images/mj', 'MidjorneyController@index')->middleware('verified')->name('images.midjorney');
Route::get('/images/mj/new', 'MidjorneyController@create')->middleware('verified')->name('images.midjorney.new');
Route::get('/images/mj/{id}/edit', 'MidjorneyController@edit')->middleware('verified')->name('images.midjorney.edit');
Route::get('/images/mj/{id}', 'MidjorneyController@show')->middleware('verified')->name('images.midjorney.show');
Route::post('/images/mj/new', 'MidjorneyController@store')->middleware('verified');
Route::post('/images/mj/{id}/edit', 'MidjorneyController@update')->middleware('verified');
Route::post('/images/mj/{id}/destroy', 'MidjorneyController@destroy')->middleware('verified')->name('images.midjorney.destroy');

// Image routes Davinci
Route::get('/images/davinci', 'DavinciController@index')->middleware('verified')->name('images.davinci');
Route::get('/images/davinci/new', 'DavinciController@create')->middleware('verified')->name('images.davinci.new');
Route::get('/images/davinci/{id}/edit', 'DavinciController@edit')->middleware('verified')->name('images.davinci.edit');
Route::get('/images/davinci/{id}', 'DavinciController@show')->middleware('verified')->name('images.davinci.show');
Route::post('/images/davinci/new', 'DavinciController@store')->middleware('verified');
Route::post('/images/davinci/{id}/edit', 'DavinciController@update')->middleware('verified');
Route::post('/images/davinci/{id}/destroy', 'DavinciController@destroy')->middleware('verified')->name('images.davinci.destroy');

// DeepFake routes
Route::get('/deepfake', 'DeepFakeController@index')->middleware('verified')->name('deepfake');
Route::get('/deepfake/new', 'DeepFakeController@create')->middleware('verified')->name('deepfake.new');
Route::get('/deepfake/{id}/edit', 'DeepFakeController@edit')->middleware('verified')->name('deepfake.edit');
Route::get('/deepfake/{id}', 'DeepFakeController@show')->middleware('verified')->name('deepfake.show');
Route::post('/deepfake/new', 'DeepFakeController@store')->middleware('verified');
Route::post('/deepfake/{id}/edit', 'DeepFakeController@update')->middleware('verified');
Route::post('/deepfake/{id}/destroy', 'DeepFakeController@destroy')->middleware('verified')->name('deepfake.destroy');


// Chat routes
// Chat GPT
Route::get('/chats/gpt', 'ChatGPTController@index')->middleware('verified')->name('chats.gpt');
Route::get('/chats/gpt/new', 'ChatGPTController@create')->middleware('verified')->name('chats.gpt.new');
Route::get('/chats/gpt/{id}/edit', 'ChatGPTController@edit')->middleware('verified')->name('chats.gpt.edit');
Route::get('/chats/gpt/{id}', 'ChatGPTController@show')->middleware('verified')->name('chats.gpt.show');
Route::get('/chats/gpt/{id}/export', 'ChatGPTController@export')->middleware('verified')->name('chats.gpt.export');
Route::post('/chats/gpt/new', 'ChatGPTController@store')->middleware('verified');
Route::post('/chats/gpt/{id}/edit', 'ChatGPTController@update')->middleware('verified');
Route::post('/chats/gpt/{id}/destroy', 'ChatGPTController@destroy')->middleware('verified')->name('chats.gpt.destroy');

// Cloude 3
Route::get('/chats/claude', 'ChatCloudeController@index')->middleware('verified')->name('chats.cloude');
Route::get('/chats/claude/new', 'ChatCloudeController@create')->middleware('verified')->name('chats.cloude.new');
Route::get('/chats/claude/{id}/edit', 'ChatCloudeController@edit')->middleware('verified')->name('chats.cloude.edit');
Route::get('/chats/claude/{id}', 'ChatCloudeController@show')->middleware('verified')->name('chats.cloude.show');
Route::get('/chats/claude/{id}/export', 'ChatCloudeController@export')->middleware('verified')->name('chats.cloude.export');
Route::post('/chats/claude/new', 'ChatCloudeController@store')->middleware('verified');
Route::post('/chats/claude/{id}/edit', 'ChatCloudeController@update')->middleware('verified');
Route::post('/chats/claude/{id}/destroy', 'ChatCloudeController@destroy')->middleware('verified')->name('chats.cloude.destroy');

// Message routes
Route::post('/messages/gpt/new', 'MessageGPTController@store')->middleware('verified')->name('messages.gpt.new');
Route::post('/messages/claude/new', 'MessageCloudeController@store')->middleware('verified')->name('messages.cloude.new');

// Speech routes
Route::get('/transcriptions', 'TranscriptionController@index')->middleware('verified')->name('transcriptions');
Route::get('/transcriptions/export', 'TranscriptionController@export')->middleware('verified')->name('transcriptions.export');
Route::get('/transcriptions/new', 'TranscriptionController@create')->middleware('verified')->name('transcriptions.new');
Route::get('/transcriptions/{id}/edit', 'TranscriptionController@edit')->middleware('verified')->name('transcriptions.edit');
Route::get('/transcriptions/{id}', 'TranscriptionController@show')->middleware('verified')->name('transcriptions.show');
Route::post('/transcriptions/new', 'TranscriptionController@store')->middleware('verified');
Route::post('/transcriptions/{id}/edit', 'TranscriptionController@update')->middleware('verified');
Route::post('/transcriptions/{id}/destroy', 'TranscriptionController@destroy')->middleware('verified')->name('transcriptions.destroy');

// Runway routes
Route::group(['prefix'=>'runway'], function (){

    // Runway text routes
    Route::group(['prefix'=>'text'], function (){
        Route::get('/', 'RunwayTextController@index')->middleware('verified')->name('runway.text');
        Route::get('/new', 'RunwayTextController@create')->middleware('verified')->name('runway.text.new');
        Route::get('/{id}/edit', 'RunwayTextController@edit')->middleware('verified')->name('runway.text.edit');
        Route::get('/{id}', 'RunwayTextController@show')->middleware('verified')->name('runway.text.show');
        Route::post('/new', 'RunwayTextController@store')->middleware('verified')->name('runway.text.store');
        Route::post('/{id}/edit', 'RunwayTextController@update')->middleware('verified');
        Route::post('/{id}/destroy', 'RunwayTextController@destroy')->middleware('verified')->name('runway.text.destroy');
    });

    // Runway image routes
    Route::group(['prefix'=>'image'], function (){
        Route::get('/', 'RunwayImageController@index')->middleware('verified')->name('runway.image');
        Route::get('/new', 'RunwayImageController@create')->middleware('verified')->name('runway.image.new');
        Route::get('/{id}/edit', 'RunwayImageController@edit')->middleware('verified')->name('runway.image.edit');
        Route::get('/{id}', 'RunwayImageController@show')->middleware('verified')->name('runway.image.show');
        Route::post('/new', 'RunwayImageController@store')->middleware('verified')->name('runway.image.store');
        Route::post('/{id}/edit', 'RunwayImageController@update')->middleware('verified');
        Route::post('/{id}/destroy', 'RunwayImageController@destroy')->middleware('verified')->name('runway.image.destroy');
    });

    // Runway image description routes
    Route::group(['prefix'=>'image_description'], function (){
        Route::get('/', 'RunwayImageDescriptionController@index')->middleware('verified')->name('runway.image_description');
        Route::get('/new', 'RunwayImageDescriptionController@create')->middleware('verified')->name('runway.image_description.new');
        Route::get('/{id}/edit', 'RunwayImageDescriptionController@edit')->middleware('verified')->name('runway.image_description.edit');
        Route::get('/{id}', 'RunwayImageDescriptionController@show')->middleware('verified')->name('runway.image_description.show');
        Route::post('/new', 'RunwayImageDescriptionController@store')->middleware('verified')->name('runway.image_description.store');
        Route::post('/{id}/edit', 'RunwayImageDescriptionController@update')->middleware('verified');
        Route::post('/{id}/destroy', 'RunwayImageDescriptionController@destroy')->middleware('verified')->name('runway.image_description.destroy');
    });

});

//Stab Diff routes
Route::group(['prefix'=>'stabdiff'], function (){

    // Stab Diff text routes
    Route::group(['prefix'=>'text'], function (){
        Route::get('/', 'StabDiffTextController@index')->middleware('verified')->name('stabdiff.text');
        Route::get('/new', 'StabDiffTextController@create')->middleware('verified')->name('stabdiff.text.new');
        Route::get('/{id}/edit', 'StabDiffTextController@edit')->middleware('verified')->name('stabdiff.text.edit');
        Route::get('/{id}', 'StabDiffTextController@show')->middleware('verified')->name('stabdiff.text.show');
        Route::post('/new', 'StabDiffTextController@store')->middleware('verified')->name('stabdiff.text.store');
        Route::post('/{id}/edit', 'StabDiffTextController@update')->middleware('verified');
        Route::post('/{id}/destroy', 'StabDiffTextController@destroy')->middleware('verified')->name('stabdiff.text.destroy');
    });

    // Stab Diff image routes
    Route::group(['prefix'=>'image'], function (){
        Route::get('/', 'StabDiffImageController@index')->middleware('verified')->name('stabdiff.image');
        Route::get('/new', 'StabDiffImageController@create')->middleware('verified')->name('stabdiff.image.new');
        Route::get('/{id}/edit', 'StabDiffImageController@edit')->middleware('verified')->name('stabdiff.image.edit');
        Route::get('/{id}', 'StabDiffImageController@show')->middleware('verified')->name('stabdiff.image.show');
        Route::post('/new', 'StabDiffImageController@store')->middleware('verified')->name('stabdiff.image.store');
        Route::post('/{id}/edit', 'StabDiffImageController@update')->middleware('verified');
        Route::post('/{id}/destroy', 'StabDiffImageController@destroy')->middleware('verified')->name('stabdiff.image.destroy');
    });
});

// Account routes
Route::prefix('account')->middleware('verified')->group(function () {
    Route::get('/', 'AccountController@index')->name('account');

    Route::get('/profile', 'AccountController@profile')->name('account.profile');
    Route::post('/profile', 'AccountController@updateProfile')->name('account.profile.update');
    Route::post('/profile/resend', 'AccountController@resendAccountEmailConfirmation')->name('account.profile.resend');
    Route::post('/profile/cancel', 'AccountController@cancelAccountEmailConfirmation')->name('account.profile.cancel');

    Route::get('/security', 'AccountController@security')->name('account.security');
    Route::post('/security', 'AccountController@updateSecurity');

    Route::get('/preferences', 'AccountController@preferences')->name('account.preferences');
    Route::post('/preferences', 'AccountController@updatePreferences');

    Route::get('/plan', 'AccountController@plan')->name('account.plan');
    Route::post('/plan', 'AccountController@updatePlan')->middleware('payment');

    Route::get('/payments', 'AccountController@indexPayments')->middleware('payment')->name('account.payments');
    Route::get('/payments/{id}/edit', 'AccountController@editPayment')->middleware('payment')->name('account.payments.edit');
    Route::post('/payments/{id}/cancel', 'AccountController@cancelPayment')->name('account.payments.cancel');

    Route::get('/invoices/{id}', 'AccountController@showInvoice')->middleware('payment')->name('account.invoices.show');

    Route::get('/api', 'AccountController@api')->name('account.api');
    Route::post('/api', 'AccountController@updateApi');

    Route::get('/delete', 'AccountController@delete')->name('account.delete');
    Route::post('/destroy', 'AccountController@destroyUser')->name('account.destroy');
});

// Admin routes
Route::prefix('admin')->middleware(['admin', 'license'])->group(function () {
    Route::redirect('/', 'admin/dashboard');

    Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');

    Route::get('/settings/{id}', 'AdminController@settings')->name('admin.settings');
    Route::post('/settings/{id}', 'AdminController@updateSetting');

    Route::get('/users', 'AdminController@indexUsers')->name('admin.users');
    Route::get('/users/new', 'AdminController@createUser')->name('admin.users.new');
    Route::get('/users/{id}/edit', 'AdminController@editUser')->name('admin.users.edit');
    Route::post('/users/new', 'AdminController@storeUser');
    Route::post('/users/{id}/edit', 'AdminController@updateUser');
    Route::post('/users/{id}/destroy', 'AdminController@destroyUser')->name('admin.users.destroy');
    Route::post('/users/{id}/disable', 'AdminController@disableUser')->name('admin.users.disable');
    Route::post('/users/{id}/restore', 'AdminController@restoreUser')->name('admin.users.restore');

    Route::get('/pages', 'AdminController@indexPages')->name('admin.pages');
    Route::get('/pages/new', 'AdminController@createPage')->name('admin.pages.new');
    Route::get('/pages/{id}/edit', 'AdminController@editPage')->name('admin.pages.edit');
    Route::post('/pages/new', 'AdminController@storePage');
    Route::post('/pages/{id}/edit', 'AdminController@updatePage');
    Route::post('/pages/{id}/destroy', 'AdminController@destroyPage')->name('admin.pages.destroy');

    Route::get('/payments', 'AdminController@indexPayments')->name('admin.payments');
    Route::get('/payments/{id}/edit', 'AdminController@editPayment')->name('admin.payments.edit');
    Route::post('/payments/{id}/approve', 'AdminController@approvePayment')->name('admin.payments.approve');
    Route::post('/payments/{id}/cancel', 'AdminController@cancelPayment')->name('admin.payments.cancel');

    Route::get('/invoices/{id}', 'AdminController@showInvoice')->name('admin.invoices.show');

    Route::get('/plans', 'AdminController@indexPlans')->name('admin.plans');
    Route::get('/plans/new', 'AdminController@createPlan')->name('admin.plans.new');
    Route::get('/plans/{id}/edit', 'AdminController@editPlan')->name('admin.plans.edit');
    Route::post('/plans/new', 'AdminController@storePlan');
    Route::post('/plans/{id}/edit', 'AdminController@updatePlan');
    Route::post('/plans/{id}/disable', 'AdminController@disablePlan')->name('admin.plans.disable');
    Route::post('/plans/{id}/restore', 'AdminController@restorePlan')->name('admin.plans.restore');

    Route::get('/coupons', 'AdminController@indexCoupons')->name('admin.coupons');
    Route::get('/coupons/new', 'AdminController@createCoupon')->name('admin.coupons.new');
    Route::get('/coupons/{id}/edit', 'AdminController@editCoupon')->name('admin.coupons.edit');
    Route::post('/coupons/new', 'AdminController@storeCoupon');
    Route::post('/coupons/{id}/edit', 'AdminController@updateCoupon');
    Route::post('/coupons/{id}/disable', 'AdminController@disableCoupon')->name('admin.coupons.disable');
    Route::post('/coupons/{id}/restore', 'AdminController@restoreCoupon')->name('admin.coupons.restore');

    Route::get('/tax-rates', 'AdminController@indexTaxRates')->name('admin.tax_rates');
    Route::get('/tax-rates/new', 'AdminController@createTaxRate')->name('admin.tax_rates.new');
    Route::get('/tax-rates/{id}/edit', 'AdminController@editTaxRate')->name('admin.tax_rates.edit');
    Route::post('/tax-rates/new', 'AdminController@storeTaxRate');
    Route::post('/tax-rates/{id}/edit', 'AdminController@updateTaxRate');
    Route::post('/tax-rates/{id}/disable', 'AdminController@disableTaxRate')->name('admin.tax_rates.disable');
    Route::post('/tax-rates/{id}/restore', 'AdminController@restoreTaxRate')->name('admin.tax_rates.restore');

    Route::get('/templates', 'AdminController@indexTemplates')->name('admin.templates');
    Route::get('/templates/new', 'AdminController@createTemplate')->name('admin.templates.new');
    Route::get('/templates/{id}/edit', 'AdminController@editTemplate')->name('admin.templates.edit');
    Route::post('/templates/new', 'AdminController@storeTemplate');
    Route::post('/templates/{id}/edit', 'AdminController@updateTemplate');
    Route::post('/templates/{id}/destroy', 'AdminController@destroyTemplate')->name('admin.templates.destroy');

    Route::get('/documents', 'AdminController@indexDocuments')->name('admin.documents');
    Route::get('/documents/{id}/edit', 'AdminController@editDocument')->name('admin.documents.edit');
    Route::post('/documents/{id}/edit', 'AdminController@updateDocument');
    Route::post('/documents/{id}/destroy', 'AdminController@destroyDocument')->name('admin.documents.destroy');

    Route::get('/images', 'AdminController@indexImages')->name('admin.images');
    Route::get('/images/{id}/edit', 'AdminController@editImage')->name('admin.images.edit');
    Route::post('/images/{id}/edit', 'AdminController@updateImage');
    Route::post('/images/{id}/destroy', 'AdminController@destroyImage')->name('admin.images.destroy');

    Route::get('/chats', 'AdminController@indexChats')->name('admin.chats');
    Route::get('/chats/{id}/edit', 'AdminController@editChat')->name('admin.chats.edit');
    Route::post('/chats/{id}/edit', 'AdminController@updateChat');
    Route::post('/chats/{id}/destroy', 'AdminController@destroyChat')->name('admin.chats.destroy');

    Route::get('/transcriptions', 'AdminController@indexTranscriptions')->name('admin.transcriptions');
    Route::get('/transcriptions/{id}/edit', 'AdminController@editTranscription')->name('admin.transcriptions.edit');
    Route::post('/transcriptions/{id}/edit', 'AdminController@updateTranscription');
    Route::post('/transcriptions/{id}/destroy', 'AdminController@destroyTranscription')->name('admin.transcriptions.destroy');
});

// Pricing routes
Route::prefix('pricing')->middleware('payment')->group(function () {
    Route::get('/', 'PricingController@index')->name('pricing');
});

// Checkout routes
Route::prefix('checkout')->middleware(['verified', 'payment'])->group(function () {
    Route::get('/cancelled', 'CheckoutController@cancelled')->name('checkout.cancelled');
    Route::get('/pending', 'CheckoutController@pending')->name('checkout.pending');
    Route::get('/complete', 'CheckoutController@complete')->name('checkout.complete');

    Route::get('/{id}', 'CheckoutController@index')->name('checkout.index');
    Route::post('/{id}', 'CheckoutController@process');
});

// Cronjob routes
Route::get('/cronjob', 'CronjobController@index')->name('cronjob');

// Webhook routes
Route::post('webhooks/paypal', 'WebhookController@paypal')->name('webhooks.paypal');
Route::post('webhooks/stripe', 'WebhookController@stripe')->name('webhooks.stripe');
Route::post('webhooks/razorpay', 'WebhookController@razorpay')->name('webhooks.razorpay');
Route::post('webhooks/paystack', 'WebhookController@paystack')->name('webhooks.paystack');
Route::post('webhooks/cryptocom', 'WebhookController@cryptocom')->name('webhooks.cryptocom');
Route::post('webhooks/coinbase', 'WebhookController@coinbase')->name('webhooks.coinbase');

// Developer routes
Route::prefix('/developers')->group(function () {
    Route::get('/', 'DeveloperController@index')->name('developers');
    Route::get('/documents', 'DeveloperController@documents')->name('developers.documents');
    Route::get('/images', 'DeveloperController@images')->name('developers.images');
    Route::get('/chats', 'DeveloperController@chats')->name('developers.chats');
    Route::get('/messages', 'DeveloperController@messages')->name('developers.messages');
    Route::get('/transcriptions', 'DeveloperController@transcriptions')->name('developers.transcriptions');
    Route::get('/account', 'DeveloperController@account')->name('developers.account');
});


Route::get('/test', 'TestController@index')->name('test');
