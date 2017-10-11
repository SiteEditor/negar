<div <?php echo $sed_attrs; ?> class="module module-terms module-terms-default <?php echo $class; ?> ">
	<div class="module-terms-inner">
	    <?php

	    if( $show_title && !empty( $terms ) ) {

	        ?>
			<div class="header-terms">
		        <div class="terms-entry-title"><h4><?php echo $fiter_title .' ';?></h4></div>
		    </div>
	        <?php

	    }

	    if ( !empty( $terms ) ){

	        ?>

	        <div class="content-terms">

		        <div class="row">

		            <?php

		            $number = 0;
		            // Start the Loop.
		            foreach( $terms AS $term ){

		            	//var_dump($number % 5 == 0);

		            	if( $number == 0 ) {
			            	?> <div class="col-sm-3"> <?php
		            	} else if($number % 5 == 0) {
		            		?> </div><div class="col-sm-3"> <?php
		            	}

		                include dirname(__FILE__) . '/content.php';

		                $number++;

		            }

		            ?>

		            </div>

		        </div>

	        </div>

	        <?php

	    }

	    ?>
	    
	</div>
</div>
