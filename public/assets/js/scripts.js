$(window).on('load', function() {
  if (feather) {
      feather.replace({
          width: 14,
          height: 14
      });
  }
})


const delete_form = $('.delete_form');
delete_form.submit(function(e){
    e.preventDefault();
     Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this record!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
})

// //User Management
var dtUserTable = $('.user-list-table');  
var newUserSidebar = $('.new-user-modal');
var newUserForm = $('.add-new-user');
var EditUserForm = $('.user_edit_form');

var dt_user = dtUserTable.DataTable({      
  // order: [[2, 'desc']],
    // dom:
    // '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
    // '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
    // '<"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>' +
    // '>t' +
    // '<"d-flex justify-content-between mx-2 row mb-1"' +
    // '<"col-sm-12 col-md-6"i>' +
    // '<"col-sm-12 col-md-6"p>' +
    // '>',
    // buttons: [
    // {
    //     text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Add New User',
    //     className: 'create-new btn btn-success',
    //     attr: {
    //       'data-bs-toggle': 'modal',
    //       'data-bs-target': '#user-modals'
    //     },
    //     init: function (api, node, config) {
    //       $(node).removeClass('btn-secondary');
    //     }
    // }
    // ]
});    

//   // User Form Validation
  if (newUserForm.length) {
    newUserForm.validate({
      errorClass: 'error',
      rules: {
        'name': {
          required: true
        },
        'email': {
          required: true,
          email: true
        },
        'password': {
          required: true
        },
        'confirm_password': {
            required: true,
            equalTo: '#password'
        },
        'roles': {
            required: true
        }
      }
    });
  }

// //User Edit Form
if(EditUserForm.length) {
    EditUserForm.validate({
        errorClass: 'error',
        rules: {
            'name': {
              required: true
            },
            'email': {
              required: true,
              email: true
            },            
            'confirm_password': {              
                equalTo: '#password'
            },
            'roles': {
                required: true
            }
          }
    });
}


// //Role Management
var dtRoleTable = $('.role-list-table');  
var newRoleSidebar = $('.new-role-modal');
var newRoleForm = $('.add-new-role');
var EditRoleForm = $('.role_edit_form');

var dt_role = dtRoleTable.DataTable({  
    order: [[2, 'desc']],
//   dom: '<"card-header border-bottom p-1"<"user-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    dom:
    '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
    '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
    '<"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>' +
    '>t' +
    '<"d-flex justify-content-between mx-2 row mb-1"' +
    '<"col-sm-12 col-md-6"i>' +
    '<"col-sm-12 col-md-6"p>' +
    '>',
    buttons: [
    {
        text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Add New Role',
        className: 'create-new-role btn btn-success',
        attr: {        
          'href': createRoleUrl
        },
        init: function (api, node, config) {
          $(node).removeClass('btn-secondary');
        }
    }
    ]
});    

//   // User Form Validation
  if (newUserForm.length) {
    newUserForm.validate({
      errorClass: 'error',
      rules: {
        'name': {
          required: true
        },
        'email': {
          required: true,
          email: true
        },
        'password': {
          required: true
        },
        'confirm_password': {
            required: true,
            equalTo: '#password'
        },
        'roles': {
            required: true
        }
      }
    });
  }

//   //User Edit Form
if(EditUserForm.length) {
    EditUserForm.validate({
        errorClass: 'error',
        rules: {
            'name': {
              required: true
            },
            'email': {
              required: true,
              email: true
            },            
            'confirm_password': {              
                equalTo: '#password'
            },
            'roles': {
                required: true
            }
          }
    });
}

// //Edit Password
var editPasswordForm = $('.editPasswordForm');
// User Form Validation
if (editPasswordForm.length) {
  editPasswordForm.validate({
    errorClass: 'error',
    rules: {
      'current_password': {
        required: true
      },      
      'new_password': {
        required: true,
      },
      'confirm_password': {
          required: true,
          equalTo: '#new_password'
      }
    }
  });
}

//plan management
var dtPlanTable = $('.plan-list-table');  
dtPlanTable.DataTable();    

// PayPal billing plan Management
var dtPayPalPlanTable = $('.paypal-plan-list-table');  
var newBillingPlanForm = $('.add-new-billing-plan');

var dt_paypal_plan = dtPayPalPlanTable.DataTable({  
    // order: [[1, 'desc']],
    dom:
    '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
    '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
    '<"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>' +
    '>t' +
    '<"d-flex justify-content-between mx-2 row mb-1"' +
    '<"col-sm-12 col-md-6"i>' +
    '<"col-sm-12 col-md-6"p>' +
    '>',
    buttons: [
    {
        text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Add New Plan',
        className: 'create-new-paypal-plan btn btn-success',
        attr: {
          'data-bs-toggle': 'modal',
          'data-bs-target': '#billing-modals'
        },
        init: function (api, node, config) {
          $(node).removeClass('btn-secondary');
        }
    }
    ]
});    

if (newBillingPlanForm.length) {
  newBillingPlanForm.validate({
    errorClass: 'error',
    rules: {
      'plan_name': {
        required: true
      },      
      'plan_description': {
        required: true,
      },
      'plan_frequency': {
        required: true,
      },
      'plan_frequency_interval': {
        required: true,
      },
      'plan_price': {
        required: true,
      }
    }
  });
}


//action to go to the create page when the button is clicked. 
$('.create-new-role, .create-new-trade').click(function (e) {
  var link = $(this).attr('href');
  window.location.href = link;
});

