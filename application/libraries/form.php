<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form {
    
    function form(){
        $data['title']  = "Form";
        $data['welcome']  = "Welcome to code igniter! Form page!";
        
        $data['firstName'] = array(
            'name'        => 'firstName',
            'id'          => 'firstName',
            'maxlength'   => '100',
            'size'        => '50',
            'style'       => 'width:50%'
        );
        
        $data['middleName'] = array(
            'name'        => 'middleName',
            'id'          => 'middleName',
            'maxlength'   => '100',
            'size'        => '50',
            'style'       => 'width:50%'
        );
        
        $data['lastName'] = array(
            'name'        => 'lastName',
            'id'          => 'lastName',
            'maxlength'   => '100',
            'size'        => '50',
            'style'       => 'width:50%'
        );
        
        $data['gender'] = array(
            'select'  => 'Select Sex',
            'male'  => 'Male',
            'female'    => 'Female'
        );
        
        $data['status1'] = array(
            'name'        => 'status',
            'id'          => 'status',
            'value'       => 'single',
            'checked'     => FALSE,
            'style'       => 'margin:10px',
        );
        
        $data['status2'] = array(
            'name'        => 'status',
            'id'          => 'status',
            'value'       => 'married',
            'checked'     => FALSE,
            'style'       => 'margin:10px',
        );

    }
}