require('./bootstrap');

//attach to page name
window.page = $("meta[name='page']").attr('content');
window.csrf_token = $('meta[name="csrf-token"]').attr('content');


//custom scripts
require('./custom/home');
