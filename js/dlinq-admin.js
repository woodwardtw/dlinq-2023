acf.add_filter('wysiwyg_tinymce_settings', function( mceInit, id, field ){

    // do something to mceInit
    console.log(mceInit.content_css)
    mceInit.content_css = mceInit.content_css+','+dlinq_admin_enqueue_js_scripts.theme_directory+'/css/dlinq-admin.css';
    // return
    return mceInit;

});