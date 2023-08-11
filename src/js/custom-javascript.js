console.log('custom')
// Add your JS customizations here
addEventListener("hashchange", (event) => {
    //alert(window.location.hash.substring(1));
    const scrollId = window.location.hash.substring(1);
    dlinqScrollTo(scrollId);
});

function dlinqScrollTo(id){
    const destination = document.getElementById(id);
    destination.scrollIntoView({behavior: 'smooth', block: 'start'});
}