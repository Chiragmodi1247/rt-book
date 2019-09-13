<?php

function rt_book_meta_save( $post_id , $post , $update) {
    // if(!update){
    //     return;
    // }

	if( ! current_user_can( 'edit_post' , $post_id ) ) {
		return;
	}
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return;
	}
	if( ! wp_verify_nonce( $_POST['rt_book_meta_box_nonce'], 'rt_book_save_meta_data' ) ) {
		return;
	}

    $book_meta_data = array();
    $book_meta_data['author_name'] = sanitize_text_field( $_POST['author_name']);
    $book_meta_data['price'] = sanitize_text_field( $_POST['book_price']);
    $book_meta_data['year'] = sanitize_text_field( $_POST['book_year']);
    $book_meta_data['publisher'] = sanitize_text_field( $_POST['book_publisher']);
    $book_meta_data['edition'] = sanitize_text_field( $_POST['book_edition']);

    update_post_meta( $post_id, '_book_meta_key' , $book_meta_data );
}