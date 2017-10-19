/**
 * Theme Front end main js
 *
 */

(function($) {

    $(document).ready(function() {

        var $rtl = ( $("body").hasClass("rtl-body") ) ? true : false;

        /**
         * Vertical Menu Accordion
         */

        var _SedVMenu = $('#sed_vertical_header_vertical_menu');

        _SedVMenu.find('li.menu-item.menu-item-has-children > .menu-toggle-oc').click(function(e){

            //e.preventDefault();

            var $this = $(this);

            if ($this.next().hasClass('active')) {
                $this.next().removeClass('active');
                $this.next().slideUp(350);
                $this.prev().removeClass('active');
            } else {
                $this.parent().parent().find('li .sub-menu').removeClass('active');
                $this.parent().parent().find('li .sub-menu').slideUp(350);
                $this.next().addClass('active');
                $this.next().slideDown(350);
                $this.parent().parent().find('li > a').removeClass('active');
                $this.prev().addClass('active');
            }

        });

        var $currentMenuItem = _SedVMenu.find(">.current-menu-item.menu-item-has-children");

        if( $currentMenuItem.length == 0 ){

            $currentMenuItem = _SedVMenu.find(">.current-menu-parent.menu-item-has-children");

        }

        if( $currentMenuItem.length > 0 ){

            $currentMenuItem.find(">a").addClass('active');

            $currentMenuItem.find(">ul.sub-menu").addClass('active');
            $currentMenuItem.find(">ul.sub-menu").slideDown(350);

        }

        /**
         * Vertical Menu Accordion
         */

        var scrollbarContainer =  $(".sed-shop-faq-wrapper,.sed-negar-content-scrolling,.sed-shop-faq-single"),
            scrollbarHeight =  $( window ).height() - 200;

        scrollbarContainer.css({
            height : scrollbarHeight + 'px',
        });


        scrollbarContainer.mCustomScrollbar({
            autoHideScrollbar:true ,
            advanced:{
                updateOnBrowserResize:true, /*update scrollbars on browser resize (for layouts based on percentages): boolean*/
                updateOnContentResize:true,
            },
            scrollButtons:{
                enable:false
            },
        });


        /**
         * FAQ Accordion
         */

        var _faqAccordionEl = $(".sed-shop-faq-wrapper-inner");

        _faqAccordionEl.accordion({
            heightStyle     : "content",
            active          : 0,
            collapsible     : true,
            icons           :false
        });


        /**
         * Terms Accordion
         */

        var _termsAccordionEl = $(".module-terms-inner");

        _termsAccordionEl.accordion({
            heightStyle     : "content",
            header          : ".header-terms",
            collapsible     : true,
            active          : false,
            collapsible     : true,
            icons           : false
        });

       // console.log(_termsAccordionEl);

    
        /**
         * Single Products
         */

        $(".flex-control-nav.flex-control-thumbs").livequery(function(){

            $(this).slick({
                mobileFirst 		: true ,
                arrows				: true,
                slidesToShow		: 3,
                slidesToScroll		: 1,
                dots				: false,
                centerMode			: false,
                rtl 				: $rtl,
                swipe      			: true ,
                touchMove  			: true ,
                infinite			: false,
                prevArrow : '<span class="slide-nav-bt slide-prev custom-btn custom-btn-secondary"><i class="fa fa-angle-left"></i></span>',
                nextArrow : '<span class="slide-nav-bt slide-next custom-btn custom-btn-secondary"><i class="fa fa-angle-right"></i></span>',
            });

        });

        $(".related.products > ul.products").livequery(function(){

            $(this).slick({
                mobileFirst 		: true ,
                arrows				: true,
                slidesToShow		: 4,
                slidesToScroll		: 1,
                dots				: false,
                centerMode			: false,
                rtl 				: $rtl,
                swipe      			: true ,
                touchMove  			: true ,
                infinite			: false,
                prevArrow : '<span class="slide-nav-bt slide-prev custom-btn custom-btn-secondary"><i class="fa fa-angle-left"></i></span>',
                nextArrow : '<span class="slide-nav-bt slide-next custom-btn custom-btn-secondary"><i class="fa fa-angle-right"></i></span>',
            });

        });



        /**
         * quantity Products
         */


        $( 'div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)' ).livequery(function(){
            var $testProp = $(this).find('qty');
            if ($testProp && $testProp.prop('type') != 'date') {
                // Quantity buttons
                $( this ).addClass( 'buttons_added' ).append( '<input type="button" value="+" class="plus" />' ).prepend( '<input type="button" value="-" class="minus" />' );

                // Target quantity inputs on product pages 
                $( 'input.qty:not(.product-quantity input.qty)' ).each( function() {

                    var min = parseFloat( $( this ).attr( 'min' ) );

                    if ( min && min > 0 && parseFloat( $( this ).val() ) < min ) {
                        $( this ).val( min );
                    }
                });

                $( this ).find('.plus, .minus').click( function() {

                    // Get values
                    var $qty        = $( this ).closest( '.quantity' ).find( '.qty' ),
                        currentVal  = parseFloat( $qty.val() ),
                        max         = parseFloat( $qty.attr( 'max' ) ),
                        min         = parseFloat( $qty.attr( 'min' ) ),
                        step        = $qty.attr( 'step' );

                    // Format values
                    if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
                    if ( max === '' || max === 'NaN' ) max = '';
                    if ( min === '' || min === 'NaN' ) min = 0;
                    if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

                    // Change the value
                    if ( $( this ).is( '.plus' ) ) {

                        if ( max && ( max == currentVal || currentVal > max ) ) {
                            $qty.val( max );
                        } else {
                            $qty.val( currentVal + parseFloat( step ) );
                        }

                    } else {

                        if ( min && ( min == currentVal || currentVal < min ) ) {
                            $qty.val( min );
                        } else if ( currentVal > 0 ) {
                            $qty.val( currentVal - parseFloat( step ) );
                        }

                    }

                    // Trigger change event
                    $qty.trigger( 'change' );
                });

            }
        });



        /**
         * Loading
         */

        var removePreloader = function() {
            setTimeout(function() {
                jQuery('.preloader').hide();
            }, 1500);
        };

        removePreloader();

    });


})(jQuery);
