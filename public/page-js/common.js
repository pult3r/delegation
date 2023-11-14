
// JUST FOR DEBUG !! 
function dd( obj ) {
    alert( JSON.stringify( obj, null, 4 ) ) ;
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});