<?php

class Apply extends \Eloquent {

    protected $table = 'tbl_new_apply';

    public static $rules = array(
		'ads_id' => 'unique_with:tbl_new_apply, user_id'
		);

}