$(document).ready(function(){
    $('.owl-carousel').owlCarousel({
        loop:true,
        responsiveClass:true,
        dots: true,
        margin: 10,
        responsive:{
            0:{
                items: 1,
                dots: true
            },
            600:{
                items: 3,
                dots: true,
                loop: false
            },
            1000:{
                items:5,
                dots:true,
                loop:false,
            }
        }
    });


    var $grid = $('.grid').isotope({
        itemSelector: '.grid-item',
        layoutMode: 'fitRows',
        getSortData: {
             name: '.name',
             price: '.price parseInt'
        }
    });

    $('#sort').on("click", "button", function() {
        var sortByValue = $(this).attr('data-sort-by');
        $grid.isotope({ sortBy: sortByValue });
    });

    $('.myDataTable').dataTable({ //for DataTables
        //"scrollY": "500px",
        // "scrollCollapse": true,
        "pagingType": 'full_numbers'
    });

});


// for admin side navbar

/* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft = "0";
}


