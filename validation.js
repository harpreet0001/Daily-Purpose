jQuery("form[name='login']").validate({

    
    rules: {

      'email': 
      {
        required: true,
        nowhitespace: true,
      },
      'password': 
      {
        required: true,
        nowhitespace: true,

      }
   
    },     
});

     jQuery("form[name='register']").validate({

    
    rules: {

      'firstname': 
      {
        required: true,
        lettersonly: true,
        maxlength: 300,
        nowhitespace: true,
      },
      'lastname': 
      {
        required: true,
        lettersonly: true,
        maxlength: 300,
        nowhitespace: true,
      },
      'email': 
      {
        required: true,
        nowhitespace: true,
        maxlength: 300,
        customemail : true
      },
      'password': 
      {
        required: true,
        minlength: 8,
        maxlength: 200,
        nowhitespace: true
      },
      'password_confirmation': 
      {
        required: true,
        minlength: 8,
        maxlength: 200,
        nowhitespace: true,
        equalTo : '[name="password"]'
      },
      'contact': 
      {
        required: true,
        nowhitespace: true,
        number: true,
        minlength: 9,
        maxlength: 15,
      },
      'address': 
      {
        required: true,
        nowhitespace: true,
      },
      'agree' :
      {
         required:true,
         checked:true,
      }
   
    },     
});


 jQuery("form[name='reset_login']").validate({

    
    rules: {

      'email': 
      {
        required: true,
        nowhitespace: true,
        customemail : true
      }
   
    },     
});

 jQuery("form[name='reset_email']").validate({

    
    rules: {

      'email': 
      {
        required: true,
        nowhitespace: true,
        customemail : true
      }
   
    },     
}); 
    
    

jQuery("form[name='reset_password']").validate({

    
    rules: {

      'email': 
      {
        required: true,
        nowhitespace: true,
        customemail : true
      },
      'password': 
      {
        required: true,
        nowhitespace: true,
      },
      'password_confirmation': 
      {
        required: true,
        nowhitespace: true,
      },
   
    },     
});    


jQuery("form[name='contact_form']").validate({

    
    rules: {

      'email': {
        required: true,
        nowhitespace: true,
        customemail : true
      },
      'name': {
        required: true,
        nowhitespace: true,
      },
      'topic': {
        required: true,
        nowhitespace: true,
      },
      'message':{
        required: true,
        nowhitespace: true,
      }
   
    },     
}); 




jQuery("form[name='return_form']").validate({

    
    rules: {

      'email': {
        required: true,
        nowhitespace: true,
        customemail : true
      },
      'first_name': {
        required: true,
        nowhitespace: true,
      },
      'last_name': {
        required: true,
        nowhitespace: true,
      },
      'telephone':{
        required: true,
        nowhitespace: true,
      },
      'order_id':{
        required: true,
        nowhitespace: true,
      },
      'order_date':{
        required: true,
        nowhitespace: true,
      },
      'product_name':{
        required: true,
        nowhitespace: true,
      },
      'product_code':{
        required: true,
        nowhitespace: true,
      },
      'reason':{
        required: true,
      },
      'opened':{
        required: true,
        nowhitespace: true,
      },
   
    },     
}); 

















/* Cstm Validations */
 jQuery.validator.addMethod("lettersonly", function (value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z]+[a-zA-Z\s]*$/);
  }, 'Only characters are allowed.');

  jQuery.validator.addMethod("nowhitespace", function(value, element) {
    return this.optional(element) || /^\S+/i.test(value);
  }, "Space is not allowed at the beginning.");

   jQuery.validator.addMethod("customemail", function(value, element) {
    return this.optional(element) || /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
  }, "Please enter a valid email address.");  
