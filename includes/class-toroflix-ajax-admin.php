<?phpclass TOROFLIX_admin_ajax {	public function delete_message() {	  	if( isset( $_POST[ 'action' ] ) ) {	    	$post_id = $_POST['ide'];	    	delete_post_meta( $post_id, 'reporflix' );	    	$res = [	      		'res' => 'conexion'	    	];	    	echo json_encode($res);	    	wp_die();	  	}	}}